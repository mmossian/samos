<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Modelo de gestion de paises
|--------------------------------------------------------------------------
|
*/
class Countries extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get($iso=NULL)
	{
		if(isset($iso))
		{
			return $this->db
				->where('iso', $iso)
				->get('countries')->row();
		}
		return $this->db->get('countries')->result();
	}
}