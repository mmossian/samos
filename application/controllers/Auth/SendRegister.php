<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador envio de registro de usuario
|--------------------------------------------------------------------------
|
*/
class SendRegister extends CI_Controller
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
		if(isset($_SESSION[$this->init->sessionNames['user']]))
		{
			$this->app_router->redirectTo();
		}
		$this->lang->load('validation/register', $this->init->appLang);
	}

	function index()
	{
		$data = $this->init->request['data'];
		$this->form_validation->set_rules($this->lang->line('rules'));
		if ($this->form_validation->run() == FALSE)
		{
			$message = $this->lang->line('message-general-error');
			$message['message'] = str_replace('%errors%', validation_errors(), $message['message']);
			$this->session->set_flashdata($this->init->sessionNames['message'], $message);
			$this->session->set_flashdata($this->init->sessionNames['request'], $data);
			$idLogMsg = 'user-register-error';
			$this->applog->additionalData = ['errors' => validation_errors()];
		}
		else
		{
			$this->load->model('Users/register');
			$this->load->helper('string');

			$token = random_string('sha1');
			if($this->register->insert($data, $token))
			{
				$user = $this->getUsers->get($this->register->idUser);

				if($this->_send($user, $token))
				{
					$this->session->set_flashdata($this->init->sessionNames['toast'], $this->lang->line('message-register-ok'));
					$idLogMsg = 'user-register-ok';
					$this->applog->additionalData = [
						'id_user' => $user->id_user,
						'country' => $user->country
					];
				}
				else
				{
					$this->session->set_flashdata($this->init->sessionNames['message'], $this->lang->line('message-register-error'));
					$this->register->remove($this->register->idUser);
					$idLogMsg = 'mail-send-error';
					$this->applog->additionalData = [
						'id_user' => $user->id_user,
						'country' => $user->country,
						'errors' => $this->smail->errors
					];
				}
			}
			else
			{
				$this->session->set_flashdata($this->init->sessionNames['message'], $this->lang->line('message-register-error'));
				$idLogMsg = 'user-register-error';
				$this->applog->additionalData = [
					'errors' => $this->db->error()
				];
			}
		}
		$this->applog->set('auth', $this->lang->line($idLogMsg));
		$this->app_router->redirectTo();
	}

	private function _send($user, $token)
	{
		$this->load->model('encrypt');
		$this->load->library('smail');
		$this->lang->load('mail/register', $this->init->appLang);

		$appname = $this->config->item('app-name');
		$tpl = $this->lang->line('mail-template');
		$search = [
			'%app-name%',
			'%name%',
			'%username%',
			'%baseurl%',
			'%iduser%',
			'%userhash%'
		];

		$replace = [
			$appname,
			$user->first_name,
			$user->email,
			$this->init->baseUrl,
			$this->encrypt->encode($user->id_user),
			$this->encrypt->encode($token)
		];

		$tpl['tplContent'] = str_replace($search, $replace, $tpl['tplContent']);
		$tpl['tplSignature'] = str_replace('%app-name%', $appname, $tpl['tplSignature']);
		$tpl['subject'] = $appname.' - '.$this->lang->line('user-register');
		$this->smail->subject = $tpl['subject'];
		$this->smail->message = $this->load->view('mail-tpl', $tpl, TRUE);
		$this->smail->to = $user->email;

		return $this->smail->send();
	}
}