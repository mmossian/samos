<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| LIBRERIA DE POLITICAS DE SEGURIDAD
|--------------------------------------------------------------------------
| Inicializa las variables globales a ser usadas en la aplicacion
|
|
*/
use \Bepsvpt\SecureHeaders\SecureHeaders;

class Csp
{
	private $config = NULL;
	private $baseUrl = NULL;
	public $headers = NULL;

	public function __construct()
	{
		$this->baseUrl = base_url();
		$this->_config();
	}

	public function send()
	{
		$this->_set();
		$this->headers->send();
	}

	private function _set()
	{
		$this->headers = new SecureHeaders($this->config);
	}

	/*
	Content-Security-Policy: default-src 'self' 'unsafe-inline';
	base-uri 'none';
	connect-src 'self' maps.googleapis.com www.google.com use.fontawesome.com/releases/v5.8.2/js/all.js https;
	font-src 'self' 'unsafe-inline' use.fontawesome.com/releases/v5.8.2/css/svg-with-js.css fonts.gstatic.com https;
	form-action 'self';
	frame-ancestors 'none';
	frame-src 'self' www.google.com https; img-src 'self' maps.googleapis.com www.google.com maps.gstatic.com; manifest-src 'none'; media-src 'none'; object-src 'none'; script-src 'self' 'unsafe-inline' maps.googleapis.com www.google.com/recaptcha use.fontawesome.com/releases/v5.8.2/js/all.js https:; style-src 'self' 'unsafe-inline' 'report-sample' use.fontawesome.com/releases/v5.8.2/css/svg-with-js.css https:; worker-src 'none'

	Feature-Policy: accelerometer 'self'; ambient-light-sensor 'self'; autoplay 'self'; camera 'self'; display-capture 'self'; document-domain *; encrypted-media 'self'; fullscreen 'self'; geolocation 'self'; gyroscope 'self'; magnetometer 'self'; microphone 'self'; midi 'self'; payment 'self'; picture-in-picture *; speaker 'self'; sync-xhr *; usb 'self'; vr 'self'

	default-src 'self' 'unsafe-inline'; base-uri 'self'; connect-src 'self' maps.googleapis.com www.google.com use.fontawesome.com/releases/v5.8.2/js/all.js https:; font-src 'self' 'unsafe-inline' use.fontawesome.com/releases/v5.8.2/css/svg-with-js.css fonts.gstatic.com https:; form-action 'self'; frame-ancestors 'none'; frame-src 'self' maps.googleapis.com maps.gstatic.com apis.google.com google.com https:; img-src 'self' maps.googleapis.com maps.gstatic.com www.google.com https:; manifest-src 'none'; media-src 'none'; object-src 'self'; script-src 'self' 'unsafe-inline' maps.googleapis.com maps.gstatic.com apis.google.com www.google.com/recaptcha use.fontawesome.com/releases/v5.8.2/js/all.js https:; style-src 'self' 'unsafe-inline' maps.googleapis.com maps.gstatic.com apis.google.com use.fontawesome.com/releases/v5.8.2/css/svg-with-js.css https:; worker-src 'none'
	*/
	private function _config()
	{
		$config = require FCPATH.'vendor/bepsvpt/secure-headers/config/secure-headers.php';
		$config['server'] = 'Apache/2.4.25 (Debian)';
		//$config['x-frame-options'] = 'allow-url https://googleapis.com';
		$config['csp']['default-src'] = [
			'self' => TRUE,
			'unsafe-inline' => TRUE,
			'unsafe-eval' => false
		];
		$config['csp']['base-uri'] = [
			'self' => TRUE
		];
		$config['csp']['script-src'] = [
			'allow' => [
                'maps.googleapis.com',
                'maps.gstatic.com',
                'apis.google.com',
                'www.google.com/recaptcha',
                //'use.fontawesome.com/releases/v5.8.2/js/all.js'
            ],
            'nonces' => [
				'base64-encoded',
				'data:image/svg+xml',
			],
            'schemes' => [
                'https:',
            ],
            'self' => TRUE,
            'unsafe-inline' => TRUE,
           	'unsafe-eval' => false
		];
		$config['csp']['form-action'] = [
			'self' => TRUE
		];
		$config['csp']['object-src'] = [
			'self' => TRUE
		];
		$config['csp']['style-src'] = [
			'allow' => [
				'maps.googleapis.com',
                'maps.gstatic.com',
                'apis.google.com',
                //'use.fontawesome.com/releases/v5.8.2/css/svg-with-js.css'
            ],
            'schemes' => [
                'https:',
            ],
            'self' => TRUE,
            'unsafe-inline' => TRUE,
            'add-generated-nonce' => false,
		];
		$config['csp']['img-src'] = [
			'allow' => [
				'maps.googleapis.com',
                'maps.gstatic.com',
				'www.google.com',
			],
			'nonces' => [
				'base64-encoded',
				'data:image/svg+xml,image/gif,image/jpg,image/png'
				//'',
			],
			'schemes' => [
				'https:',
				'data:'
			],
			'self' => TRUE,
			'unsafe-inline' => TRUE
		];
		$config['csp']['connect-src'] = [
			'allow' => [
				'maps.googleapis.com',
	            'www.google.com',
	            //'use.fontawesome.com/releases/v5.8.2/js/all.js'
			],
			'schemes' => [
				'https:'
			],
			'self' => TRUE
		];
		$config['csp']['frame-src'] = [
			'allow' => [
				'maps.googleapis.com',
                'maps.gstatic.com',
                'apis.google.com',
                'google.com'
            ],
            'schemes' => [
                'https:',
                'data:'
            ],
            'self' => TRUE,
            'unsafe-inline' => false,
		];
		$config['csp']['font-src'] = [
			'allow' => [
				//'use.fontawesome.com/releases/v5.8.2/css/svg-with-js.css',
				'fonts.gstatic.com'
			],
			'schemes' => [
				'https:',
				'data: application/x-font-ttf',
				//'data: application/font-woff2'
			],
			'self' => TRUE,
			'unsafe-inline' => TRUE
		];

		$config['feature-policy'] = [
			'display-capture' => [
				'self' => false
			],
			'geolocation' => [
				'self' => true,
				'allow' => [
	                'google.com'
	            ],
	            'schemes' => [
					'https:'
				]
			]

		];
		$this->config = $config;
	}
}