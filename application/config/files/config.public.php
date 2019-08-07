<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Archivos que se cargaran en la pagina publica
|--------------------------------------------------------------------------
|
*/
$config['app-files'] = [
	'views' => [
		'%lang%/auth/login',
		'%lang%/auth/forgot-pwd',
		'%lang%/auth/modal-register-resume',
		'%lang%/modal-geolocation-error',
		'%lang%/public/modal-policies',
		'%lang%/public/home'
	],
	'css' => [

	],
	'js' => [
		'js/auth.js',
		'js/location/location.js',
		'js/location/address.js',
		'moment/moment/min/moment-with-locales.min.js'
	],
	'sources' => [
		[
			'source' => 'https://www.google.com/recaptcha/api.js?hl=%lang%',
			'params' => ''
		],
		[
			'source' => 'https://maps.googleapis.com/maps/api/js?language=%lang%&key=AIzaSyC7gYBywHDf_IxnCPzbM3wHHsPDi90mwBg&v=3&libraries=places',
			'params' => 'defer'
			//'AIzaSyAOmIqx9Zvyo8bTXGOLFhKFuZKGb8h525w'
		]
	],
	'langs' => [
		'faq'
	],
	'params' => []
];