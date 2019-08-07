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
		'%lang%/first/additional-data'
	],
	'css' => [

	],
	'js' => [
		'js/phones.js',
		'js/emails.js',
		'js/users.js'
	],
	'sources' => [

	],
	'langs' => [

	]
];