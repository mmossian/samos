<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'csrf'     => \CodeIgniter\Filters\CSRF::class,
		'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
		'honeypot' => \CodeIgniter\Filters\Honeypot::class,
		'guest' => \App\Filters\Guest::class,
		'first_auth' => \App\Filters\FirstAuthenticated::class,
		'user_auth' => \App\Filters\UserAuthenticated::class,
		'assoc_auth' => \App\Filters\AssocAuthenticated::class,
	];

	// Always applied before every request
	public $globals = [
		'before' => [
			//'honeypot'
			'csrf',
		],
		'after'  => [
			'toolbar',
			//'honeypot'
		],
	];

	public $methods = [
		// 'post' => ['csrf']
	];

	public $filters = [
		'guest' => [
			'before' => ['auth/*', '/']
		],
		'first_auth' => [
			'before' => ['first/*']
		],
		'user_auth' => [
			'before' => ['user/*']
		],
		'assoc_auth' => [
			'before' => ['company/*']
		],
	];
}
