<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador pagina reseteo contrasenia de usuarios
|--------------------------------------------------------------------------
|
*/
class PasswordReset extends CI_Controller
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
		$this->app_router->setRoutes('config.password-reset');
		$this->menu->set();
	}

	function index($id_user, $token)
	{
		$this->_set($id_user, $token);
		$this->load->view('index', $this->data);
	}

	private function _set($id_user, $token)
	{
		$this->data['interface'] = 'users';
		$this->data['activePage'] = 'password-reset';
		$this->data['csrf'] = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];
		$this->data['id_user'] = $id_user;
		$this->data['token'] = $token;

		$rules =  read_file(APPPATH."language/{$this->init->appLang}/validation/password-reset.json");
		$this->data['jsParams'][] = "var Rules = {$rules};";
	}
}