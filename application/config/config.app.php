<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Archivo principal de configuracion de la aplicacion
|--------------------------------------------------------------------------
|
*/

// Nombre de la aplicacion
$config['app-name'] = 'Samos';

// Periodo de validez del registro de usuario en horas
$config['app-validation-duration'] = 3;

// Cantidad maxima de intentos de login
$config['app-max-login-attempts'] = 3;

// Cantidad maxima de intentos cambio de contrasenia
$config['app-max-chpwd-attempts'] = 3;

// Formatos fechas/horas
$config['app-format-date-db'] = '%Y-%m-%d %H:%i:%s';

// Longitud Contrasenias
$config['app-password-len'] = [
	'min' => 6,
	'max' => 20
];

// Numero maximo de correos adiconales por usuarios
$config['app-max-additionals-emails'] = 2;

// Numero maximo de telefonos adiconales por usuarios
$config['app-max-additionals-phones'] = 2;