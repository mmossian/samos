<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador pagina publica
|--------------------------------------------------------------------------
|
*/
class Home extends CI_Controller
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
		$this->load->model('countries');
		$this->app_router->setRoutes('config.public');
		$this->menu->set();
	}

	function index()
	{
		$this->_set();
		$this->load->view('index', $this->data);
	}

	private function _set()
	{
		$this->data['interface'] = 'public';
		$this->data['activePage'] = 'home';
		$this->data['csrf'] = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];

		$this->data['countries'] = $this->countries->get();
		$activeCountry = '';
		if(isset($_COOKIE[$this->init->cookieName['visitor']]))
		{
			$cookie = json_decode($_COOKIE[$this->init->cookieName['visitor']], TRUE);
			$activeCountry = $cookie['country'];
		}
		$this->data['activeCountry'] = $activeCountry;

		$fpwdRules =  read_file(APPPATH."language/{$this->init->appLang}/validation/password-recover.json");
		$this->data['jsParams'][] = "var FpwdRules = {$fpwdRules};";

		$loginRules =  read_file(APPPATH."language/{$this->init->appLang}/validation/login.json");
		$this->data['jsParams'][] = "var LoginRules = {$loginRules};";

		$registerRules =  read_file(APPPATH."language/{$this->init->appLang}/validation/register.json");
		$this->data['jsParams'][] = "var RegisterRules = {$registerRules};";
	}
}