<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE OBTENCION DE USUARIOS
|--------------------------------------------------------------------------
|
|
*/

class GetUsers extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	/*
		-------------------------------------------------------
		Obtiene usuarios
		-------------------------------------------------------
		@visibility public
		@params string
		@return object
		-------------------------------------------------------
	*/
	public function get($id_user=NULL, $email=NULL)
	{
		$this->db
			->join('users_settings', 'users_settings.id_user = users.id_user', 'inner')
			->join('emails', 'users.id_email = emails.id_email', 'inner')
			->join('users_data', 'users_data.id_user = users.id_user', 'inner')
			->join('address', 'users_data.id_address = address.id_address', 'inner')
			->join('phones', 'users_data.id_phone = phones.id_phone', 'left')
			->join('companies', 'users_data.id_company = companies.id_company', 'left');
		if(isset($id_user))
		{
			$this->db->where('users.id_user', $id_user);
		}
		if(isset($email))
		{
			$this->db->where('emails.email', $email);
		}
		return (isset($id_user) OR isset($email)) ? $this->db->get('users')->row() : $this->db->get('users')->result();
	}
}