<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR LOGIN DE USUARIOS
| -------------------------------------------------------------------
|
|
*/
class Logout extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION[$this->init->sessionNames['user']]))
		{
			$this->app_router->redirectTo();
		}
		$this->load->library('throttling');
	}

	function index()
	{
		$this->throttling->delete();
		$this->applog->additionalData = [
			'id_user' => $this->init->user->id_user,
			'email' => $this->init->user->email,
			'session_duration' => now() - $_SESSION[$this->init->sessionNames['user']]['sess_start']
		];
		$this->applog->set('auth', $this->lang->line('logout-success'));
		session_destroy();
		$this->app_router->redirectTo();
	}
}