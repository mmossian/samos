<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Archivos que se cargaran en la pagina home primera vez
|--------------------------------------------------------------------------
|
*/
$config['app-files'] = [
	'views' => [
		'navs/first',
		'%lang%/password/modal-random',
		'%lang%/first/password-data'
	],
	'css' => [

	],
	'js' => [
		'js/password.js'
	],
	'sources' => [
	],
	'langs' => [
	]
];