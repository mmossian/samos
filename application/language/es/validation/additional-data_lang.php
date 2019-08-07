<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
	----------------------------------------------------------------------------------------
	Reglas de validacion correos y telefonos adicionales
	Location: application/language/validation
	----------------------------------------------------------------------------------------
*/

$lang['rules'] = [
	[
		'field' => 'additional-email[]',
		'label' => 'Correo Adicional',
		'rules' => 'trim|valid_email'
	],
	[
		'field' => 'additional-phone[]',
		'label' => 'Tel&eacute;fono Adicional',
		'rules' => 'trim|numeric|min_length[6]|max_length[12]'
	]
];