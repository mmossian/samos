<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| ARCHIVO DE TEMPLATE DE CORREO REGISTRO DE USUARIO
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/language/es/mail
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
$lang['mail-template'] = [
	'subject' => '',
	'tplContent' => '
		<h3>Bienvenid@ %name% a %app-name%.</h3>
		<p><b>Deseamos que tu experiencia en el uso de nuestra aplicaci&oacute;n sea de tu entera conformidad y que repliques la misma sumando nuevos usuarios.</b></p>
		<p>Tu ID de usuario es: %username%</p>
		<h3>
			Haz click en el siguiente link a los efectos de validar tus datos.<br><br><br>
			<a class="btn" href="%baseurl%index.php/validateregistration/%iduser%/%userhash%" target="_blank"><b>Validar Datos</b></a>
		</h3>
	',
	'tplSignature' => 'El equipo de %app-name%.'
];