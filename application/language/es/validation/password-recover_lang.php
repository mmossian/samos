<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
	----------------------------------------------------------------------------------------
	Reglas de validacion formulario recuperacion contrasenia
	Location: application/language/validation
	----------------------------------------------------------------------------------------
*/
$lang['rules'] = [
	[
		'field' => 'email_fpwd',
        'label' => 'Correo Electr&oacute;nico',
        'rules' => 'required|valid_email'
	]
];