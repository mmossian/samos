<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
	----------------------------------------------------------------------------------------
	Mensajes log utilizados por monolog (Espanol)
	Location: application/language
	----------------------------------------------------------------------------------------

	Log Levels (https://github.com/Seldaek/monolog/blob/master/doc/01-usage.md)
	Monolog supports the logging levels described by RFC 5424.
    DEBUG (100): Detailed debug information.
    INFO (200): Interesting events. Examples: User logs in, SQL logs.
    NOTICE (250): Normal but significant events.
    WARNING (300): Exceptional occurrences that are not errors. Examples: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.
    ERROR (400): Runtime errors that do not require immediate action but should typically be logged and monitored.
    CRITICAL (500): Critical conditions. Example: Application component unavailable, unexpected exception.
    ALERT (550): Action must be taken immediately. Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up.
    EMERGENCY (600): Emergency: system is unusable.
*/

/*
	Acceso usuarios
*/
$lang['login-success'] = [
	'message' => 'El usuario %user_name% (ID = %id_user%) se ha logueado exitosamente',
	'level' => 'INFO'
];

$lang['login-error'] = [
	'message' => 'Intento de inicio de sesion fallido.',
	'level' => 'INFO'
];

$lang['logout-success'] = [
	'message' => 'Se ha cerrado sesion',
	'level' => 'INFO'
];

$lang['user-no-active'] = [
	'message' => 'Intento de login usuario desactivado',
	'level' => 'INFO'
];

/*
	Registro usuarios
*/
$lang['user-register-ok'] = [
	'message' => 'Registro de usuario exitoso.',
	'level' => 'INFO'
];

$lang['user-register-error'] = [
	'message' => 'Error de registro de usuario.',
	'level' => 'INFO'
];

$lang['user-validation-ok'] = [
	'message' => 'El usuario ha validado sus datos y ha sido activado.',
	'level' => 'INFO'
];

/*
	IP Bloqueada
*/
$lang['ip-blocked'] = [
	'message' => 'Intento de acceso IP bloqueada',
	'level' => 'ALERT'
];

/*
	Recuperacion contrasena
*/
$lang['password-recovery-sent-ok'] = [
	'message' => 'Envio de correo recuperacion contrasena exitoso',
	'level' => 'INFO'
];

$lang['password-recovery-sent-error'] = [
	'message' => 'Ha fallado el envio de recuperacion de contrasena',
	'level' => 'INFO'
];

$lang['password-validation-ok'] = [
	'message' => 'Se ha validado exitosamente la contrasena',
	'level' => 'INFO'
];

$lang['password-validation-error'] = [
	'message' => 'Se han producido errores al intentar validar contrasena',
	'level' => 'INFO'
];

$lang['password-reset-alert'] = [
	'message' => 'El usuario ha sido desactivado tras varios intentos fallidos de validar su contrasena',
	'level' => 'INFO'
];

/*
	Visitantes a la pagina
*/
$lang['new-visitor'] = [
	'message' => 'Nuevo visitante a la pagina publica',
	'level' => 'INFO'
];

/*
	Correo electronico
*/
$lang['mail-send-error'] = [
	'message' => 'Error de envio de correo',
	'level' => 'INFO'
];