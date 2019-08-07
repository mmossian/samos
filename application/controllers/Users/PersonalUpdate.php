<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador actualizacion de datos personales de usuario
|--------------------------------------------------------------------------
|
*/
class PersonalUpdate extends CI_Controller
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
		$this->lang->load('validation/personal-data', $this->init->appLang);
	}

	public function index()
	{
		$data = $this->init->request['data'];
		$this->form_validation->set_rules($this->lang->line('rules'));
		if ($this->form_validation->run() == FALSE)
		{
			$message = $this->lang->line('message-general-error');
			$message['message'] = str_replace('%errors%', validation_errors(), $message['message']);
			$this->session->set_flashdata($this->init->sessionNames['message'], $message);

			$this->session->set_flashdata($this->init->sessionNames['request'], $data);
			$this->app_router->redirectTo('personaldata');
		}
		else
		{
			$this->load->model('Users/updateUser');
			if($this->updateUser->personalData($data))
			{
				$this->session->set_flashdata($this->init->sessionNames['toast'], $this->lang->line('message-save-ok'));
			}
			else
			{
				if(isset($this->updateUser->message))
				{
					$this->session->set_flashdata($this->init->sessionNames['message'], $this->updateUser->message);
				}
				else
				{
					$this->session->set_flashdata($this->init->sessionNames['toast'], $this->lang->line('message-save-error'));
				}
			}
			$this->app_router->redirectTo('personaldata');
		}
	}
}