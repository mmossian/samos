<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Archivo de configuracion de correos de la aplicacion
|--------------------------------------------------------------------------
| Ubicacion: application/config
|
|
*/

/*
// Mailtrap conf
$config = Array(
  'protocol' => 'smtp',
  'smtp_host' => 'smtp.mailtrap.io',
  'smtp_port' => 2525,
  'smtp_user' => 'fdd9928618967d',
  'smtp_pass' => '8d1c2bb0e82004',
  'crlf' => "\r\n",
  'newline' => "\r\n"
);
*/

/*
	Correos
*/
// $config['dtr-default-email'] = 'marcelo.mossian@yahoo.com';
// $config['dtr-replyto-email'] = 'marcelo.mossian@yahoo.com';

$config['dtr-default-from'] = [
	'marcelo.mossian@yahoo.com' => 'Samos'
];

$config['smtp_crypto'] = 'ssl';
$config['charset'] = 'utf-8';
$config['wordwrap'] = TRUE;
$config['smtp_host'] = 'smtp.mail.yahoo.com';
$config['smtp_port'] = 465;
$config['smtp_pass'] = 'Maraleju_1';
$config['smtp_user'] = 'marcelo.mossian@yahoo.com';
$config['mailtype'] = 'html';
$config['dsn'] = TRUE;
$config['bcc_batch_mode'] = TRUE;
$config['bcc_batch_size'] = 200;
$config['priority'] = 1;