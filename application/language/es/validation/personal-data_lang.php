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
		'field' => 'first_name',
        'label' => 'Nombre',
        'rules' => 'trim|required|regex_match[/^[a-zA-Z]+(\s*[a-zA-Z]*)*[a-zA-Z]+$/]|max_length[20]' // Caracteres alfabeticos y espacios
	],
	[
		'field' => 'last_name',
        'label' => 'Apellido',
        'rules' => 'trim|required|regex_match[/^[a-zA-Z]+(\s*[a-zA-Z]*)*[a-zA-Z]+$/]|max_length[20]' // Caracteres alfabeticos y espacios
	],
	[
		'field' => 'phone_number',
        'label' => 'Tel&eacute;fono',
        'rules' => 'trim|required|numeric|min_length[6]|max_length[12]'
	],
	/*[
		'field' => 'additional-email[]',
		'label' => 'Correo Adicional',
		'rules' => 'trim|valid_email|is_unique[emails.email]'
	],
	[
		'field' => 'additional-phone[]',
		'label' => 'Tel&eacute;fono Adicional',
		'rules' => 'trim|numeric|min_length[6]|max_length[12]'
	]*/
];