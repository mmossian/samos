<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR LOGIN DE USUARIOS
| -------------------------------------------------------------------
|
|
*/
class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->ip->isBlocked();
		if(isset($_SESSION[$this->init->sessionNames['user']]))
		{
			$this->app_router->redirectTo();
		}
		$this->load->model('Users/validate');
		$this->load->library('throttling');
	}

	public function index()
	{
		if($this->init->request['method'] === 'post')
		{
			// Cehquea que no se haya superado la cantidad maxima de intentos de validacion
			if($this->throttling->isLocked() === TRUE)
			{
				$seconds = $this->throttling->cached['time'] -  now();
				$message = $this->lang->line('message-max-login-attempts');
				$message['message'] = str_replace('%seconds%', $seconds, $message['message']);
				$this->session->set_flashdata($this->init->sessionNames['toast'], $message);
				$this->app_router->redirectTo();
				die();
				return;
			}
			$this->lang->load('form_validation', $this->init->appLang);
			$this->lang->load('validation/login', $this->init->appLang);
			$this->form_validation->set_rules($this->lang->line('rules'));
			if ($this->form_validation->run() == FALSE)
			{
				$message = $this->lang->line('message-general-error');
				$message['message'] = str_replace('%errors%', validation_errors(), $message['message']);
				$this->session->set_flashdata($this->init->sessionNames['toast'], $message);
				$this->throttling->increment();
			}
			else
			{
				// Valida el usuario
				$this->validate->auth();
				switch ($this->validate->status)
				{
					case 'user-no-active':
						$this->throttling->increment();
						$this->session->set_flashdata($this->init->sessionNames['message'], $this->lang->line('message-user-no-active'));
						$this->applog->additionalData = [
							'id_user' => $this->validate->user->id_user,
							'email' => $this->validate->user->email
						];
						$this->applog->set('auth', $this->lang->line('user-no-active'));
					break;

					case 'error':
						$this->throttling->increment();
						$this->session->set_flashdata($this->init->sessionNames['toast'], $this->lang->line('message-login-error'));
						$this->applog->set('auth', $this->lang->line('login-error'));
					break;

					default:
						$msg = $this->lang->line('login-success');
						$msg['message'] = str_replace(
							['%user_name%', '%id_user%'],
							[$this->validate->user->first_name .' '. $this->validate->user->last_name, $this->validate->user->id_user],
							$msg['message']
						);
						$this->applog->additionalData = [
							'id_user' => $this->validate->user->id_user,
							'email' => $this->validate->user->email
						];
						$this->applog->set('auth', $msg);
						$this->throttling->delete();
					break;
				}
			}
			$this->app_router->redirectTo();
		}
	}
}