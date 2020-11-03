<?php
namespace App\Controllers;

class Home extends BaseController
{

	public function index()
	{
		$this->set();
		return \Config\Services::renderView('home.twig', $this->data);
	}

	private function set()
	{
		$this->data['IdPage'] = 'home';
		$this->data['IdMenu'] = 'home';
		$this->data['Content'] = lang('Pages/Home.content');

	}

}
