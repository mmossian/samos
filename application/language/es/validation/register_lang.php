<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
	----------------------------------------------------------------------------------------
	Reglas de validacion formulario registro
	Location: application/language/validation
	----------------------------------------------------------------------------------------
*/

$lang['rules'] = [
	[
		'field' => 'country',
        'label' => 'Pa&iacute;s',
        'rules' => 'trim|required'
	],
	[
		'field' => 'email',
        'label' => 'Correo Electr&oacute;nico',
        'rules' => 'trim|required|valid_email|is_unique[emails.email]'
	],
	[
		'field' => 'first_name',
        'label' => 'Nombre',
        'rules' => 'trim|required|max_length[20]'
	],
	[
		'field' => 'last_name',
        'label' => 'Apellido',
        'rules' => 'trim|required|max_length[20]'
	],
	[
		'field' => 'g-recaptcha-response',
        'label' => 'No soy un robot',
        'rules' => 'trim|required'
	]
];