<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE GESTION DE CORREOS
|--------------------------------------------------------------------------
|
|
*/

class Emails extends CI_Model
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
		Obtiene correos
		-------------------------------------------------------
		@visibility public
		@params int | int
		@return object
		-------------------------------------------------------
	*/
	public function get($id_email=NULL, $id_user=NULL)
	{
		if(!isset($id_user))
		{
			$id_user = $this->init->user->id_user;
		}
		$this->db->join('emails', 'emails.id_email = users_emails.id_email', 'inner');
		if(isset($id_email))
		{
			$this->db->where('users_emails.id_email', $id_email);
		}
		$this->db->where('users_emails.id_user', $id_user);
		$this->db->where('users_emails.id_email !=', $this->init->user->id_email);
		$emails = $this->db->get('users_emails');
		return isset($id_email) ? $emails->row() : $emails->result();
	}

	/*
		-------------------------------------------------------
		Salva correos de usuario adicionales
		-------------------------------------------------------
		@visibility public
		@params array
		@return boolean
		-------------------------------------------------------
	*/
	public function saveAdditionals($emails)
	{
		$this->db->trans_start();
		foreach($emails as $k => $v)
		{
			$result = [];
			if(isset($v->id_email) AND $v->email != $this->init->user->email)
			{
				$exists = $this->db
					->join('emails', 'emails.id_email = users_emails.id_email', 'inner')
					->where('users_emails.id_user !=', $this->init->user->id_user)
					->where('emails.email', $v->email)
					->count_all_results('users_emails');
				if($exists == 0)
				{
					$result['email'] = $v->email;
					$this->db
						->where('id_email', $v->id_email)
						->update('emails', $result);
				}
				else
				{
					$this->_formatError($v->email);
					return FALSE;
				}
			}
			else
			{
				$exists = $this->db
					->get_where('emails', ['email' => $v->email])
					->num_rows();
				if($exists == 0)
				{
					$result['email'] = $v->email;
					$this->db->insert('emails', $result);
					$lastEmailId = $this->db->insert_id();

					$result = [];
					$result['id_user'] = $this->init->user->id_user;
					$result['id_email'] = $lastEmailId;
					$this->db->insert('users_emails', $result);
				}
				else
				{
					$this->_formatError($v->email);
					return FALSE;
				}
			}
		}
		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	private function _formatError($email)
	{
		$error = $this->lang->line('message-email-exists');
		$error['message'] = str_replace('%email%', $email, $error['message']);
		$this->error = $error;
	}
}