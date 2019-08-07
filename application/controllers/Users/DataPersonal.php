<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador pagina datos personales de usuarios
|--------------------------------------------------------------------------
|
*/
class DataPersonal extends CI_Controller
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
		$cfgFile = $this->init->user->user_first == 0 ? 'config.personal-data' : 'config.first-personal-data';
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
		$this->data['activePage'] = 'home';
		$this->data['csrf'] = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];

		// Telefono Principal
		$this->data['mainPhone'] = $this->phones->getMain();

		// Listado de prefijos a ser mostrados en los dropdowns
		$this->data['prefixes'] = $this->phones->getPrefixes();

		// Prefijo telefono principal
		if(!empty($this->set_values->set('phone_prefix')))
		{
			$this->data['phone_prefix'] = $this->set_values->set('phone_prefix');
		}
		elseif ($this->data['mainPhone'])
		{
			$this->data['phone_prefix'] = $this->data['mainPhone']->phone_prefix;
		}
		else
		{
			$this->data['phone_prefix'] = $this->phones->getPrefix($this->init->user->country)->phone;
		}

		$this->data['btnNextStatus'] = is_null($this->init->user->id_phone) ? 'disabled' : '';
		$this->data['btnNextHref'] = 'additionaldata';
		$this->data['activeView'] = $this->init->appLang.'/first/personal-data';

		$rules =  read_file(APPPATH."language/{$this->init->appLang}/validation/personal-data.json");
		$this->data['jsParams'][] = "var Rules = {$rules};";
	}
}