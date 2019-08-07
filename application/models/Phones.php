<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE GESTION DE NUMEROS TELEFONICOS
|--------------------------------------------------------------------------
|
|
*/

class Phones extends CI_Model
{
	/*
		@error
		Descripcion: Id mensaje de error
			Referenciado en messages_lang.php
		Tipo: string
	*/
	public $error = NULL;

	public function __construct()
	{
		parent::__construct();
	}

	/*
		-------------------------------------------------------
		Obtiene telefono principal
		-------------------------------------------------------
		@visibility public
		@params void
		@return object
		-------------------------------------------------------
	*/
	public function getMain()
	{
		return $this->db
			->join('users_data', 'phones.id_phone = users_data.id_phone', 'inner')
			->where('users_data.id_user', $this->init->user->id_user)
			->get('phones')
			->row();
	}

	/*
		-------------------------------------------------------
		Obtiene telefonos que no se corresponden con el principal
		-------------------------------------------------------
		@visibility public
		@params int | int
		@return object
		-------------------------------------------------------
	*/
	public function get($id_phone=NULL, $id_user=NULL)
	{
		$this->db->join('phones', 'phones.id_phone = users_phones.id_phone', 'inner');
		if(isset($id_phone))
		{
			$this->db->where('users_phones.id_phone', $id_phone);
		}
		if(isset($id_user))
		{
			$this->db->where('users_phones.id_user', $id_user);
		}
		$phones = $this->db
			->where('users_phones.id_phone !=', $this->init->user->id_phone)
			->get('users_phones');
		return isset($id_phone) ? $phones->row() : $phones->result();
	}

	/*
		-------------------------------------------------------
		Obtiene prefijo
		-------------------------------------------------------
		@visibility public
		@params string
		@return object
		-------------------------------------------------------
	*/
	public function getPrefix($iso)
	{
		return $this->db
			->select('iso,country,phone')
			->get_where('countries', ['iso' => $iso])
			->row();
	}

	/*
		-------------------------------------------------------
		Obtiene todos los prefijos
		-------------------------------------------------------
		@visibility public
		@params void
		@return object
		-------------------------------------------------------
	*/
	public function getPrefixes()
	{
		return $this->db
			->select('iso,country,phone')
			->get('countries')
			->result();
	}

	/*
		-------------------------------------------------------
		Salva el telefono principal del usuario
		-------------------------------------------------------
		@visibility public
		@params array
		@return boolean
		-------------------------------------------------------
	*/
	public function saveMain($data)
	{
		$result = [];
		$fullphone = $data['phone_prefix'].'-'.$data['phone_number'];
		$exists = $this->db->get_where('phones', ['phone_full' => $fullphone]);
		if($exists->num_rows() == 0)
		{
			$this->db->trans_start();
			if(!is_null($this->init->user->id_phone))
			{
				$result['phone_prefix'] = $data['phone_prefix'];
				$result['phone_number'] = $data['phone_number'];
				$this->db
					->where('id_phone', $data['id_phone'])
					->update('phones', $result);
			}
			else
			{
				$result['phone_prefix'] = $data['phone_prefix'];
				$result['phone_number'] = $data['phone_number'];
				$this->db->insert('phones', $result);
				$lastPhoneId = $this->db->insert_id();

				$result = [];
				$result['id_user'] = $this->init->user->id_user;
				$result['id_phone'] = $lastPhoneId;
				$this->db->insert('users_phones', $result);

				$result = [];
				$result['id_phone'] = $lastPhoneId;
				$this->db
					->where('id_user', $this->init->user->id_user)
					->update('users_data', $result);
			}
			$this->db->trans_complete();

			return $this->db->trans_status();
		}
		$this->error = $this->lang->line('message-phone-exists');
		return FALSE;
	}

	/*
		-------------------------------------------------------
		Salva el telefonos adicionales del usuario
		-------------------------------------------------------
		@visibility public
		@params array
		@return boolean
		-------------------------------------------------------
	*/
	public function saveAdditionals($phones)
	{
		$this->db->trans_start();
		foreach($phones as $k => $v)
		{
			$result = [];
			$fullphone = $v->phone_prefix.'-'.$v->phone_number;
			if(isset($v->id_phone) AND $fullphone != $this->init->user->phone_full)
			{
				$exists = $this->db
					->join('phones', 'phones.id_phone = users_phones.id_phone', 'inner')
					->where('phones.phone_full', $fullphone)
					->where('users_phones.id_user !=', $this->init->user->id_user)
					->get('users_phones')
					->num_rows();

				if($exists == 0)
				{
					$result['phone_number'] = $v->phone_number;
					$result['phone_prefix'] = $v->phone_prefix;
					$this->db
						->where('id_phone', $v->id_phone)
						->update('phones', $result);
				}
				else
				{
					$this->_formatError($fullphone);
					return FALSE;
				}
			}
			else
			{
				$exists = $this->db
					->get_where('phones', ['phone_full' => $fullphone])
					->num_rows();
				if($exists == 0)
				{
					$result['phone_number'] = $v->phone_number;
					$result['phone_prefix'] = $v->phone_prefix;
					$this->db->insert('phones', $result);
					$lastPhoneId = $this->db->insert_id();

					$result = [];
					$result['id_user'] = $this->init->user->id_user;
					$result['id_phone'] = $lastPhoneId;
					$this->db->insert('users_phones', $result);
				}
				else
				{
					$this->_formatError($fullphone);
					return FALSE;
				}
			}
		}
		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	private function _formatError($phone)
	{
		$error = $this->lang->line('message-phone-exists');
		$error['message'] = str_replace('%phone%', $phone, $error['message']);
		$this->error = $error;
	}
}