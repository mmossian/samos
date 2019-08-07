<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE ACTUALIZACION DATOS USUARIOS
|--------------------------------------------------------------------------
|
|
*/

class UpdateUser extends CI_Model
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

	public function personalData($data)
	{
		$this->load->model('phones');
		$result['first_name'] = $data['first_name'];
		$result['last_name'] = $data['last_name'];
		$this->db->where('id_user', $this->init->user->id_user);
		if($this->db->update('users_data', $result))
		{
			$this->phones->saveMain($data);
			if(isset($this->phones->message))
			{
				$this->message = $this->phones->message;
				return FALSE;
			}
			return TRUE;
		}
		return FALSE;
	}

	public function additionalData($data)
	{
		$phones = json_decode($data['additionals_phones']);
		$emails = json_decode($data['additionals_emails']);
		if(count($phones) > 0)
		{
			$this->load->model('phones');
			if($this->phones->saveAdditionals($phones) === FALSE)
			{
				$this->error = $this->phones->error;
				return FALSE;
			}
		}
		if(count($emails) > 0)
		{
			$this->load->model('emails');
			if($this->emails->saveAdditionals($emails) === FALSE)
			{
				$this->error = $this->emails->error;
				return FALSE;
			}
		}

		return TRUE;
	}
}