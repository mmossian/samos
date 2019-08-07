<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador actualizacion de telefonos y correos adicionales de usuario
|--------------------------------------------------------------------------
|
*/
class AdditionalUpdate extends CI_Controller
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
		$this->lang->load('validation/additional-data', $this->init->appLang);
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
			if(isset($data['additionals_phones']))
			{
				$this->session->set_flashdata('additional-phones', $data['additionals_phones']);
			}
			if(isset($data['additionals_emails']))
			{
				$this->session->set_flashdata('additional-email', $data['additionals_emails']);
			}
		}
		else
		{
			$this->load->model('Users/updateUser');
			if($this->updateUser->additionalData($data) === TRUE)
			{
				$this->session->set_flashdata($this->init->sessionNames['toast'], $this->lang->line('message-save-ok'));
			}
			else
			{
				if(!is_null($this->updateUser->error))
				{
					$this->session->set_flashdata($this->init->sessionNames['message'], $this->updateUser->error);
				}
				else
				{
					$this->session->set_flashdata($this->init->sessionNames['toast'], $this->lang->line('message-save-error'));
				}
				$this->session->set_flashdata('additional-phones', $data['additionals_phones']);
			}
		}
		$this->app_router->redirectTo('additionaldata');
	}
}