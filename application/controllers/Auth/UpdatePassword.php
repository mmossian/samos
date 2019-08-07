<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador actualizacion de contrasenia de usuario logueado
|--------------------------------------------------------------------------
|
*/
class UpdatePassword extends CI_Controller
{
	/*
		@data
		Descripcion: Datos pasados a la vista
		Tipo: array
	*/
	private $data = [];

	public function __construct()
	{
		parent::__construct();
		$this->ip->isBlocked();
		if(!isset($_SESSION[$this->init->sessionNames['user']]))
		{
			$this->app_router->redirectTo();
		}
		$this->load->model('password');
		$this->load->library('throttling');
		$this->lang->load('validation/password-data', $this->init->appLang);
	}

	public function index()
	{
		if($this->throttling->isLocked() === TRUE)
		{
			$this->_lockUser();
		}
		$this->form_validation->set_rules($this->lang->line('rules'));
		if ($this->form_validation->run() == FALSE)
		{
			$message = $this->lang->line('message-general-error');
			$message['message'] = str_replace('%errors%', validation_errors(), $message['message']);
			$this->session->set_flashdata($this->init->sessionNames['message'], $message);
		}
		else
		{
			if($this->password->update())
			{
				$this->session->set_flashdata($this->init->sessionNames['toast'], $this->lang->line('message-password-update-ok'));
				$this->throttling->delete();
			}
			else
			{
				$this->throttling->lifeTime = $this->config->item('sess_expiration');
				$this->throttling->increment();
				if(isset($this->password->error))
				{
					$this->session->set_flashdata($this->init->sessionNames['message'], $this->lang->line($this->password->error));
				}
				else
				{
					$this->session->set_flashdata($this->init->sessionNames['message'], $this->lang->line('message-password-recover-error'));
				}
			}

		}
		$this->app_router->redirectTo('passworddata');
	}

	private function _lockUser()
	{
		$this->load->helper('string');

		$this->applog->additionalData = [
			'id_user' => $this->init->user->id_user
		];
		$this->applog->set('auth', $this->lang->line('password-reset-alert'));

		$this->db->trans_start();
		$data['user_active'] = 0;
		$this->db
			->where('id_user', $this->init->user->id_user)
			->update('users', $data);
		$expiration = now() + $this->config->item('app-validation-duration') * 3600;
		$token = random_string('sha1');
		$d['id_user'] = $this->init->user->id_user;
		$d['token'] = $token;
		$d['expiration'] = mdate($this->config->item('app-format-date-db'), $expiration);
		$this->db->insert('users_reset_pwd', $d);
		$this->db->trans_complete();

		$this->_sendEmail($token);
		$this->app_router->redirectTo('logout');
	}

	private function _sendEmail($token)
	{
		$this->load->library('smail');
		$this->load->model('encrypt');
		$this->lang->load('mail/password-reset', $this->init->appLang);

		$app_name = $this->config->item('app-name');

		$tpl = $this->lang->line('mail-template');
		$tpl['subject'] = str_replace('%app-name%', $app_name, $tpl['subject']);
		$tpl['tplSignature'] = str_replace('%app-name%', $app_name, $tpl['tplSignature']);
		$tpl['tplContent'] = str_replace(
			['%name%', '%baseurl%', '%iduser%', '%userhash%'],
			[
				$this->init->user->first_name,
				$this->init->baseUrl,
				$this->encrypt->encode($this->init->user->id_user),
				$this->encrypt->encode($token)
			],
			$tpl['tplContent']
		);

		$this->smail->subject = $tpl['subject'];
		$this->smail->to = [ $this->init->user->email => $this->init->user->first_name];
		$this->smail->message = $this->load->view('mail-tpl', $tpl, TRUE);
		return $this->smail->send();
	}
}