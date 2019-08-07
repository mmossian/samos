<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	----------------------------------------------------------------------------------------
	Modelo de chequeo de ips
	Location: application/models
	----------------------------------------------------------------------------------------
*/

class Ip extends CI_Model
{
	private $ip = NULL;

	public function __construct()
	{
		parent::__construct();
		$this->ip = $this->input->ip_address();
	}

	public function isBlocked()
	{
		$result = $this->db->get_where('blocked_ip', ['ip' => $this->ip]);
		if($result->num_rows() > 0)
		{
			session_destroy();
			$this->app_router->redirectTo('blockedIp');
		}
	}
}