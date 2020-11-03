<?php

return [
	'public' => [
		'home' => [
			'name' => 'Inicio',
			'url' => '/',
			'icon' => 'icon home'
		],
		'faq' => [
			'name' => 'Faq',
			'url' => '#',
			'icon' => 'icon question circle'
		],
		'login' => [
			'name' => 'Acceso',
			'url' => '/auth/login',
			'icon' => 'icon sign in alternate'
		],
		'signup' => [
			'name' => 'Registro',
			'url' => '/auth/register',
			'icon' => 'icon users'
		],
	],
	'admin' => [
		'dashboard' => [
			'header' => 'General',
			'items' => [
				'dashboard' => [
					'name' => 'Dashboard',
					'icon' => 'icon tachometer alternate',
					'url' => '/admin/home'
				]
			]
		],
		'invoices' => [
			'header' => 'Ventas',
			'items' => [
				'invoices_list' => [
					'name' => 'Listado',
					'icon' => 'icon check circle outline',
					'url' => '/admin/invoice'
				]
			]
		],
		'users' => [
			'header' => 'Usuarios',
			'items' => [
				'users_list' => [
					'name' => 'Listado',
					'icon' => 'icon user',
					'url' => '/admin/users'
				]
			]
		],
		'winners' => [
			'header' => 'Ganadores',
			'items' => [
				'winner_list' => [
					'name' => 'Listado',
					'icon' => 'icon list',
					'url' => '/admin/winners'
				],
				'winner_new' => [
					'name' => 'Agregar',
					'icon' => 'icon add',
					'url' => '/admin/winneradd'
				]
			]
		],
	],
];