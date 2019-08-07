<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Libreria de gestion de menu
|--------------------------------------------------------------------------
|
*/
class Menu
{
	/*
		@CI
		Descripcion: Nueva instancia de la aplicacion
		Tipo: string
	*/
	protected $CI = NULL;

	/*
		@topMenuItems
		Descripcion: Items del menu top
		Tipo: array
	*/
	public $topMenuItems = [];

	/*
		@sideBarMenuItems
		Descripcion: Items del menu sideBar
		Tipo: array
	*/
	public $sideBarMenuItems = NULL;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function set()
	{
		if(isset($_SESSION[$this->CI->init->sessionNames['user']]))
		{
			if($this->CI->init->user->user_first == 1)
			{
				$this->CI->lang->load('menu/first', $this->CI->init->appLang);
			}
			else
			{
				$this->CI->lang->load('menu/'.$this->CI->init->user->user_role, $this->CI->init->appLang);
				$this->sideBarMenuItems = $this->CI->lang->line('app-sidebar');
			}
		}
		else
		{
			$this->CI->lang->load('menu/public', $this->CI->init->appLang);
		}
		$this->topMenuItems = $this->CI->lang->line('app-menu');
	}
}