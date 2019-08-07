<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador pagina datos adicionales de usuarios
|--------------------------------------------------------------------------
|
*/
class DataAdditional extends CI_Controller
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
		$this->load->model('phones');
		$this->load->model('emails');
		$cfgFile = $this->init->user->user_first == 0 ? 'config.additional-data' : 'config.first-additional-data';
		$this->app_router->setRoutes($cfgFile);
		$this->menu->set();
	}

	function index()
	{
		$this->_set();
		$this->load->view('index', $this->data);
	}

	private function _set()
	{
		$this->data['interface'] = 'users';
		$this->data['activePage'] = 'additional-data';
		$this->data['csrf'] = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];

		$this->data['maxPhones'] = $this->config->item('app-max-additionals-phones');
		$this->data['maxEmails'] = $this->config->item('app-max-additionals-emails');

		// Listado de prefijos a ser mostrados en los dropdowns
		$this->data['prefixes'] = $this->phones->getPrefixes();

		// Telefonos adicionales
		$phones = $this->phones->get(NULL, $this->init->user->id_user);
		$additionalPhones = [];
		if($phones)
		{
			foreach($phones as $k => $p)
			{
				$additionalPhones[$k]['phone_number'] = $p->phone_number;
				$additionalPhones[$k]['phone_prefix'] = $p->phone_prefix;
				$additionalPhones[$k]['id_phone'] = $p->id_phone;
			}
			$this->data['additionalPhones'] = json_encode($additionalPhones);
		}
		elseif(isset($_SESSION['additional-phones']))
		{
			$this->data['additionalPhones'] = $_SESSION['additional-phones'];
		}
		else
		{
			$this->data['additionalPhones'] = json_encode($additionalPhones);
		}


		// Emails adicionales
		$additionalEmails = [];
		$emails = $this->emails->get();
		if($emails)
		{
			foreach($emails as $k => $p)
			{
				$additionalEmails[$k]['email'] = $p->email;
				$additionalEmails[$k]['id_email'] = $p->id_email;
			}
			$this->data['additionalEmails'] = json_encode($additionalEmails);
		}
		elseif(isset($_SESSION['additional-email']))
		{
			$this->data['additionalEmails'] = $_SESSION['additional-email'];
		}
		else
		{
			$this->data['additionalEmails'] = json_encode($additionalEmails);
		}

		$this->data['btnNextStatus'] = is_null($this->init->user->id_email) ? 'disabled' : '';
		$this->data['btnNextHref'] = 'passworddata';
		$this->data['btnPreviousHref'] = 'personaldata';
		$this->data['activeView'] = $this->init->appLang.'/users/additional-data';

		$rules =  read_file(APPPATH."language/{$this->init->appLang}/validation/personal-data.json");
		$this->data['jsParams'][] = "var Rules = {$rules};";
	}

	public function removeAdditionalPhone()
	{
		if($this->input->is_ajax_request())
		{
			$id_phone = $this->init->request['data']['id_phone'];
			$response = 0;
			if($this->db->delete('phones', ['id_phone' => $id_phone]))
			{
				$response = 1;
			}
			echo $response;
		}
	}

	public function removeAdditionalEmail()
	{
		if($this->input->is_ajax_request())
		{
			$id_email = $this->init->request['data']['id_email'];
			$response = 0;
			if($this->db->delete('emails', ['id_email' => $id_email]))
			{
				$response = 1;
			}
			echo $response;
		}
	}
}