<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Archivos que se cargaran en la pagina reseteo de contrasenia
|--------------------------------------------------------------------------
|
*/
$config['app-files'] = [
	'views' => [
		'%lang%/auth/password-reset'
	],
	'css' => [

	],
	'js' => [
		'js/password.js'
	],
	'sources' => [
		[
			'source' => 'https://www.google.com/recaptcha/api.js?hl=%lang%',
			'params' => ''
		]
	],
	'langs' => [
	]
];