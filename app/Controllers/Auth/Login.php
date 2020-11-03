<?php
namespace App\Controllers\Auth;

use App\Services\Authorize;

class Login extends BaseController
{
	public function __construct()
	{
		Authorize::constructor();
	}

	public function index()
	{
		$this->set();
		return \Config\Services::renderView('auth/login.twig', $this->data);
	}

	private function set()
	{
		$this->data['Content'] = lang('Pages/Login.content');
		$this->data['IdPage'] = 'login';
		$this->data['IdMenu'] = 'login';
		$this->data['Rules'] = \Config\Services::setJsonRules('Login.json');
	}

	public function login()
	{
		return Authorize::auth($this->request);
	}

}
