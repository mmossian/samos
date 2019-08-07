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
		'%lang%/first/home'
	],
	'css' => [

	],
	'js' => [
		'js/phones.js',
		'js/users.js'
	],
	'sources' => [
		[
			'source' => 'https://maps.googleapis.com/maps/api/js?language=%lang%&key=AIzaSyC7gYBywHDf_IxnCPzbM3wHHsPDi90mwBg&v=3&libraries=places',
			'params' => 'defer'
		]
	],
	'langs' => [

	]
];