<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador pagina cambio contrasenia de usuarios
|--------------------------------------------------------------------------
|
*/
class DataPassword extends CI_Controller
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
		$this->load->library('throttling');
		$cfgFile = $this->init->user->user_first == 0 ? 'config.password-data' : 'config.first-password-data';
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
		$this->data['activePage'] = 'password-data';
		$this->data['csrf'] = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];

		$this->data['btnNextStatus'] = '';
		$this->data['btnNextHref'] = '#';
		$this->data['btnPreviousHref'] = 'additionaldata';
		$this->data['requireCurPwd'] = TRUE;
		$this->data['activeView'] = $this->init->appLang.'/users/password-data';

		$rules =  read_file(APPPATH."language/{$this->init->appLang}/validation/password-data.json");
		$this->data['jsParams'][] = "var Rules = {$rules};";

		if($this->throttling->isLocked() === TRUE)
		{
			$msg = json_encode($this->lang->line('message-password-reset-alert'));
			$this->data['jsParams'][] = "var DeactiveUserMsg = {$msg};";
		}
	}
}