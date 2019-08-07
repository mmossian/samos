<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR RECUPERACION CONTRASENA
| -------------------------------------------------------------------
|
|
*/
class PasswordRecover extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->ip->isBlocked();
		if(isset($_SESSION[$this->init->user_session_name]))
		{
			$this->redirectTo->set();
		}
	}

	/*
		-------------------------------------------------------
		Envia un correo al usuario si este existe y esta activo
		-------------------------------------------------------
		@visibility public
		@params string
		@return void
		-------------------------------------------------------
	*/
	public function index()
	{
		$this->lang->load('validation/password-recover', $this->init->appLang);
		$email = $this->init->request['data']['email_fpwd'];
		$user = $this->getUsers->getUserByEmail($email);
		$this->form_validation->set_rules($this->lang->line('rules'));
		if ($this->form_validation->run() == FALSE)
		{
			$message = $this->lang->line('message-general-error');
			$message['message'] = str_replace('%errors%', validation_errors(), $message['message']);
			$this->session->set_flashdata($this->init->message_session_name, $message);
		}
		else
		{
			$idMessage = 'message-user-no-exists';
			if($user)
			{
				$idMessage = 'message-user-not-active';
				if($user->active == 1)
				{
					$this->load->helper('string');
					$token = random_string('sha1');
					$idMessage = 'message-ups-error';
					$expiration = now() + $this->config->item('app-validation-duration');
					$this->db->delete('users_reset_pwd', ['id_user' => $user->id_user]);
					$data = [
						'id_user' => $user->id_user,
						'token' => $token,
						'expiration' => mdate($this->config->item('app-format-date-db'), $expiration)
					];
					if($this->_sendMail($user, $token) AND $this->db->insert('users_reset_pwd', $data))
					{
						$idMessage = 'message-mail-sent-ok';
						$this->applog->additionalData = [
							'id_user' => $user->id_user,
							'email' => $user->email
						];
						$this->applog->set('auth', $this->lang->line('password-recovery-sent-ok'));
					}
					else
					{
						$this->applog->additionalData = [
							'id_user' => $user->id_user,
							'email' => $user->email,
							'db_error' => $this->db->error(),
							'email_error' => $this->smail->errors
						];
						$this->applog->set('auth', $this->lang->line('password-recovery-sent-error'));
					}
				}
			}
			$this->session->set_flashdata($this->init->toast_message_session_name, $this->lang->line($idMessage));
		}
		$this->redirectTo->set();
	}

	private function _sendMail($user, $token)
	{
		$this->load->model('smail');
		$this->lang->load('mail/password-recover', $this->init->appLang);
		$this->load->model('encrypt');

		$appname = $this->config->item('app-name');
		$tpl = $this->lang->line('mail-template');
		$search = [
			'%app-name%',
			'%baseurl%',
			'%iduser%',
			'%userhash%'
		];

		$replace = [
			$appname,
			$this->init->baseUrl,
			$this->encrypt->encode($user->id_user),
			$this->encrypt->encode($token)
		];

		$tpl['tplContent'] = str_replace($search, $replace, $tpl['tplContent']);
		$tpl['tplSignature'] = str_replace('%app-name%', $appname, $tpl['tplSignature']);
		$this->smail->subject = str_replace('%app-name%', $appname, $tpl['subject']);
		$this->smail->message = $this->load->view('mail-tpl', $tpl, TRUE);
		$this->smail->to = $user->email;

		return $this->smail->send();
	}
}