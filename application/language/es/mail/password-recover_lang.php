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
	'subject' => '%app-name% - Recuperacion de contrasena',
	'tplContent' => '
		<h3>Estimado@ Usuari@.</h3>
		<p><b>Manten tu contrase&ntilde;a segura.</b></p>
		<p>No compartas tu contrase&ntilde;a con nadie.</p>
		<p>Evita utilizar claves comunes como tu nombre, aniversarios, etc.</p>
		<h3>
			Haz click en el siguiente link a los efectos de cambiar tu contrase&ntilde;a.<br><br><br>
			<a class="btn" href="%baseurl%index.php/validatepwd/%iduser%/%userhash%" target="_blank"><b>Recuperar Contrase&ntilde;a</b></a>
		</h3>
	',
	'tplSignature' => 'El equipo de %app-name%.'
];