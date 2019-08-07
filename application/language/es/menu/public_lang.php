<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Archivo de internacionalizacion menu publico (Espanol)
|--------------------------------------------------------------------------
|
*/
$lang['app-menu'] = [
	'id' => 'public-menu',
	'items' => [
		'home' => [
			'name' => 'inicio',
			'icon' => 'home',
			'url' => '#home'
		],
		'faq' => [
			'name' => 'faq',
			'icon' => 'circle question',
			'url' => '#faq'
		],
		'contact' => [
			'name' => 'contacto',
			'icon' => 'envelope',
			'url' => '#contact'
		],
		'login' => [
			'name' => 'acceso',
			'icon' => 'users',
			'url' => '#'
		]
	]
];