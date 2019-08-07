<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
	----------------------------------------------------------------------------------------
	Mensajes internacionalizacion (Espanol)
	Location: application/language
	----------------------------------------------------------------------------------------
*/

/*
	Mensajes de error generico
*/
$lang['message-general-error'] = [
	'header' => 'ERROR!!!',
	'message' => '%errors%.',
	'cls' => 'red',
	'icon' => 'exclamation triangle'
];

$lang['message-ups-error'] = [
	'title' => 'Uppps.!!!!',
	'message' => 'Algo salio mal',
	'cls' => 'error',
	'duration' => 5000
];

/*
	Mensajes de actualizacion y eliminacion de registros
*/
$lang['message-save-ok'] = [
	'title' => 'Bien',
	'message' => 'El registro ha sido exitosamente salvado.',
	'cls' => 'success',
	'duration' => 5000
];
$lang['message-save-error'] = [
	'title' => 'ERROR !!!',
	'message' => 'No se ha podido salvar el registro.',
	'cls' => 'error',
	'duration' => 5000
];

/*
	Mensajes de registro de usuario
*/
$lang['message-register-ok'] = [
	'title' => 'Te has registrado',
	'message' => 'El registro ha sido enviado a tu direcci&oacute;n de correo para su validaci&oacute;n.',
	'cls' => 'success',
	'duration' => 8000
];
$lang['message-register-error'] = [
	'header' => 'ERROR!!! Algo sali&oacute; mal.',
	'message' => '<p>El registro ha fallado.</p><p>Int&eacute;ntalo nuevamente en unos segundos.</p><p>Si el problema persiste, comun&iacute;cate con nuestro personal.</p>',
	'cls' => 'red',
	'icon' => 'exclamation triangle'
];

$lang['message-validation-ok'] = [
	'title' => 'Has validado tus datos exitosamente',
	'message' => 'Tu usuario ha sido activado. Redirigiendo ....',
	'cls' => 'success',
	'duration' => 5000,
	'href' => ''
];

/*
	Mensajes autorizaciones usuarios
*/
$lang['message-login-error'] = [
	'title' => 'Error de Validacion',
	'message' => 'Chequee sus credenciales',
	'cls' => 'error',
	'duration' => 5000
];
$lang ['message-max-login-attempts'] = [
	'title' => 'Se ha superado el numero maximo de intentos de acceso.',
	'message' => 'Vuelva a intentarlo en %seconds% segundos',
	'cls' => 'warning',
	'duration' => 8000
];
$lang['message-user-no-active'] = [
	'message' => 'El usuario no se encuentra activo',
	'cls' => 'yellow',
	'icon' => 'exclamation triangle',
	'duration' => 5000
];
$lang['message-user-no-exists'] = [
	'title' => 'Error',
	'message' => 'No existe un usuario con esas credenciales.',
	'cls' => 'error',
	'duration' => 5000
];
$lang['message-user-not-active'] = [
	'title' => 'Error',
	'message' => 'El usuario no se encuentra activo',
	'cls' => 'error',
	'duration' => 5000
];

/*
	Mensajes correo electronico
*/
$lang['message-mail-sent-ok'] = [
	'title' => 'Genial',
	'message' => 'El correo ha sido enviado',
	'cls' => 'success',
	'duration' => 5000
];

/*
	Mensajes correo electronico
*/
$lang['message-password-recover-ok'] = [
	'title' => 'La contrasenia ha sido actualizada',
	'message' => 'Redireccionando al sitio web',
	'cls' => 'success',
	'duration' => 5000,
	'href' => ''
];

$lang['message-password-update-ok'] = [
	'title' => 'Bien !!!',
	'message' => 'Tu contrasenia ha sido actualizada',
	'cls' => 'success',
	'duration' => 5000
];

$lang['message-password-recover-error'] = [
	'header' => 'Error !!!',
	'message' => 'La contrasenia no ha podido ser actualizada',
	'cls' => 'red',
	'icon' => 'exclamation triangle'
];

$lang['message-password-no-match'] = [
	'header' => 'Error !!!',
	'message' => 'La contrase&ntilde;a actual no coincide',
	'cls' => 'red',
	'icon' => 'exclamation triangle'
];

$lang['message-password-reset-alert'] = [
	'title' => 'Usuario Desactivado. Chequea tu correo electronico',
	'message' => 'Tu usuario ha sido desactivado a los efectos de que verifiques tu identidad y resetees tu contrasenia.',
	'cls' => 'error',
	'duration' => 15000
];

/*
	Mensajes de actualizacion de datos de usuarios
*/
$lang['message-phone-exists'] = [
	'header' => 'Error !!!',
	'message' => 'El telefono %phone% ya se encuentra registrado.',
	'cls' => 'red',
	'icon' => 'exclamation triangle'
];

$lang['message-email-exists'] = [
	'header' => 'Error !!!',
	'message' => 'El correo electr&oacute;nico %email% ya se encuentra registrado.',
	'cls' => 'red',
	'icon' => 'exclamation triangle'
];