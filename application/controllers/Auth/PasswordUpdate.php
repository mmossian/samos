<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR ACTUALIZACION CONTRASENA AL MOMENTO DEL REGISTRO
| -------------------------------------------------------------------
|
|
*/
class PasswordUpdate extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		$this->ip->isBlocked();
		if(isset($_SESSION[$this->init->user_session_name]))
		{
			$this->redirectTo->set();
		}
		$this->load->model('password');
		$this->lang->load('validation/password', $this->init->appLang);
	}

	public function index()
	{
		$this->form_validation->set_rules($this->lang->line('rules'));
		if ($this->form_validation->run() == FALSE)
		{
			$message = $this->lang->line('message-general-error');
			$message['message'] = str_replace('%errors%', validation_errors(), $message['message']);
			$this->session->set_flashdata($this->init->message_session_name, $message);
			$this->redirectTo->set('validatepwderror');
		}
		else
		{
			$data = $this->init->request['data'];
			$pwd['user_pwd'] = $this->password->setPwd($data['newpwd']);
			$this->db->trans_start();
				$this->db
					->where('id_user', $data['id_user'])
					->update('users', $pwd);
				$this->db->delete('users_reset_pwd', ['id_user' => $data['id_user']]);

			$this->db->trans_complete();
			if($this->db->trans_status() === TRUE)
			{
				$this->applog->additionalData = [
					'id_user' => $data['id_user']
				];
				$this->applog->set('auth', $this->lang->line('password-validation-ok'));

				$this->session->set_flashdata($this->init->toast_message_session_name, $this->lang->line('message-password-recover-ok'));
				$this->redirectTo->set('validatepwdsuccess');
			}
			else
			{
				$this->applog->additionalData = [
					'id_user' => $data['id_user'],
					'db_error' => $this->db->error()
				];
				$this->applog->set('auth', $this->lang->line('password-validation-error'));

				$this->session->set_flashdata($this->init->message_session_name, $this->lang->line('message-password-recover-error'));
				$this->redirectTo->set('validatepwderror');
			}
		}
	}

	public function success()
	{
		$data['appFiles'] = $this->filesConfig->set('password-validation-success');
		$data['idPage'] = 'password-recover-success';
		$data['interface'] = 'password_recover';
		$this->load->view('index', $data);
	}

	public function error()
	{
		$data['appFiles'] = $this->filesConfig->set('password-validation-error');
		$data['idPage'] = 'password-recover-error';
		$data['interface'] = 'password_recover';
		$this->load->view('index', $data);
	}
}