<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR RECUPERACION CONTRASENA
| -------------------------------------------------------------------
|
|
*/
class PasswordValidation extends CI_Controller
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
		$this->load->model('encrypt');
	}

	public function index($id_user, $token)
	{
		$this->_set($id_user, $token);
		$this->load->view('index', $this->data);
	}

	private function _set($id_user, $token)
	{
		$id_user = $this->encrypt->decode($id_user);
		$token = $this->encrypt->decode($token);
		$user = $this->db->get_where('users_reset_pwd', ['id_user' => $id_user, 'token' => $token])->row();
		if($user)
		{
			$this->lang->load('validation/password', $this->init->appLang);
			$this->lang->load('validation/password-recover', $this->init->appLang);
			$this->data['appFiles'] = $this->filesConfig->set('password-validation');
			$this->data['id_user'] = $user->id_user;
			$this->data['idPage'] = 'password-recover';
			$this->data['interface'] = 'password_recover';
			$this->data['csrf'] = [
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			];
			// Reglas validacion nueva contrasenia
			$pwdRules = json_encode($this->lang->line('password-rules'), JSON_FORCE_OBJECT);
			$this->data['fns'][] = "var pwdRules = {$pwdRules};";
		}
		else
		{
			$this->data['appFiles'] = $this->filesConfig->set('password-validation-expired');
		}
	}
}