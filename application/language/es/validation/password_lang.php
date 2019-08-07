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
		'field' => 'newpwd',
        'label' => 'La contrase&ntilde;a debe tener un m&iacute;nimo de 6 y un m&aacute;ximo de 20 caracteres',
        'rules' => 'required|min_length[6]|max_length[20]'
	],
	[
		'field' => 'rnewpwd',
        'label' => 'Las contrase&ntilde;as no coinciden',
        'rules' => 'required|matches[newpwd]'
	]
];