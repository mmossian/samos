<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Modelo de registro de Usuarios
|--------------------------------------------------------------------------
|
*/
class Register extends CI_Model
{
	/*
		@tables
		Descripcion: Tablas en las que se insertaran los datos
		Tipo: array
	*/
	private $tables = [
		'users',
		'users_data',
		'address',
		'emails'
	];

	/*
		@idUser
		Descripcion: Id del usuario insertado
		Tipo: array
	*/
	public $idUser = NULL;

	public function __construct()
	{
		parent::__construct();
	}

	/************************************************
		Descripcion: Inserta un usuario
		@visibility public
		@params array | string
		@return boolean
	************************************************/
	public function insert($data, $token)
	{
		$result = $this->_setData($data);
		$this->db->trans_start();
			// Inserto tabla emails
			$this->db->insert('emails', $result['emails']);
			$lastEmailId = $this->db->insert_id();

			// Inserto tabla address
			$this->db->insert('address', $result['address']);
			$lastAddressId = $this->db->insert_id();

			// Inserto tabla users
			$result['users']['id_email'] = $lastEmailId;
			$this->db->insert('users', $result['users']);
			$lastUserId = $this->db->insert_id();
			$this->idUser = $lastUserId;

			// Inserto tabla pivot users_emails
			$result['users_emails']['id_user'] = $lastUserId;
			$result['users_emails']['id_email'] = $lastEmailId;
			$this->db->insert('users_emails', $result['users_emails']);

			// Inserto tabla users_data
			$result['users_data']['id_user'] = $lastUserId;
			$result['users_data']['id_address'] = $lastAddressId;
			$this->db->insert('users_data', $result['users_data']);

			// Inserto tabla users_settings
			$result['users_settings']['id_user'] = $lastUserId;
			$this->db->insert('users_settings', $result['users_settings']);

			// Inserto tabla users_validation
			$expiration = now() + $this->config->item('app-validation-duration') * 3600;
			$result['users_validation']['id_user'] = $lastUserId;
			$result['users_validation']['token'] = $token;
			$result['users_validation']['expiration'] = mdate($this->config->item('app-format-date-db'), $expiration);
			$this->db->insert('users_validation', $result['users_validation']);

		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	/************************************************
		Descripcion: Elimina el usuario insertado en
			caso de fallar el envio de correo
		@visibility public
		@params int
		@return void
	************************************************/
	public function remove($id_user)
	{
		$user = $this->getUsers->get($id_user);
		$this->db->delete('emails', ['id_email' => $user->id_email]);
		$this->db->delete('users', ['id_user' => $user->id_user]);
		$this->db->delete('address', ['id_address' => $user->id_address]);
		$this->db->delete('users_validation', ['id_user' => $user->id_user]);
	}

	/************************************************
		Descripcion: Establece los datos a ser insertados
		@visibility private
		@params array
		@return array
	************************************************/
	private function _setData($data)
	{
		$result = [];
		foreach ($this->tables as $t)
		{
			foreach($data as $k => $v)
			{
				if ($this->db->field_exists($k, $t))
				{
					$result[$t][$k] = $v;
				}
			}
		}
		$result['users']['user_entered'] = mdate($this->config->item('app-format-date-db'), now());
		$result['users']['user_last_ip'] = $this->input->ip_address();
		return $result;
	}
}