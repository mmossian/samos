<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
	----------------------------------------------------------------------------------------
	Reglas de validacion formulario login
	Location: application/language/validation
	----------------------------------------------------------------------------------------
*/
$lang['rules'] = [
	[
		'field' => 'user_email',
        'label' => 'Correo Electr&oacute;nico',
        'rules' => 'required|valid_email'
	],
	[
		'field' => 'user_pwd',
        'label' => 'Contrase&ntile;a',
        'rules' => 'required|min_length[6]|max_length[20]'
	]
];