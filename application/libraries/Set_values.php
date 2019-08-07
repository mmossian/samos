<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Libreria de gestion de datos pasados via get post
|--------------------------------------------------------------------------
|
*/
class Set_values {
	/*
		@CI
		Descripcion: Nueva instancia de la aplicacion
		Tipo: string
	*/
	protected $CI = NULL;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function set($id_field)
	{
		if(isset($_SESSION[$this->CI->init->sessionNames['request']]))
		{
			return $_SESSION[$this->CI->init->sessionNames['request']][$id_field];
		}
		return '';
	}
}