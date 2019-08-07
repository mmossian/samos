<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Registra un nuevo vistante a la pagina publica
|--------------------------------------------------------------------------
|
*/
class Visitor extends CI_Controller
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
		if(isset($_SESSION[$this->init->sessionNames['user']]))
		{
			$this->app_router->redirectTo();
		}
	}

	public function index()
	{
		if($this->input->is_ajax_request())
		{
			if(!isset($_COOKIE[$this->init->cookieName['is-user']]))
			{
				$now = now();
				$data = $this->init->request['data'];
				$data['expiration'] = $now + 3600;
				$cookie = $this->_setCookie($data);
				if($cookie !== FALSE)
				{
					$cookieData = json_decode($cookie, TRUE);
					if($cookieData['expiration'] < $now)
					{
						delete_cookie($this->init->cookieName['visitor']);
						$this->_setCookie($data);
					}
				}
			}
		}
	}

	private function _setCookie($data)
	{
		if(!isset($_COOKIE[$this->init->cookieName['visitor']]))
		{
			set_cookie(
				$this->init->cookieName['visitor'], // Nombre
				json_encode($data), // Valor
				$data['expiration'] // Expiracion
			);
			$this->applog->additionalData = [
				'address' => $data['address'],
				'country' => $data['country'],
				'timezone' => $data['timezone']
			];
			$this->applog->set('visitor', $this->lang->line('new-visitor'));
			return FALSE;
		}
		return $_COOKIE[$this->init->cookieName['visitor']];
	}
}