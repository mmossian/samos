<?php
/*
    Swift_Mime_SimpleMessage::PRIORITY_HIGHEST: 1
    Swift_Mime_SimpleMessage::PRIORITY_HIGH: 2
    Swift_Mime_SimpleMessage::PRIORITY_NORMAL: 3
    Swift_Mime_SimpleMessage::PRIORITY_LOW: 4
    Swift_Mime_SimpleMessage::PRIORITY_LOWEST: 5
*/
return [
	'mail-footer' => 'El equipo de {app-name}',
	// Olvido de contrasenia
	'mail-forgot-password-sent' => [
		'priority' => 1,
		'subject' => 'Recuperación de Contraseña',
		'body' => '
			<p>Hola {username}</p>
			<p>Recibimos una solicitud para restaurar tu contraseña. Si no has sido tu, simplemente descarta este correo.</p>
			<p>Cliqueá en el siguiente botón para restaurar tu contraseña.</p>
			<br>
			<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                <tbody>
                  <tr>
                    <td align="left"
                      style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                      <table border="0" cellpadding="0" cellspacing="0"
                        style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                        <tbody>
                          <tr>
                            <td
                              style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #3498db; border-radius: 5px; text-align: center;">
                              <a href="{href}" target="_blank"
                                style="display: inline-block; color: #ffffff; background-color: #006ea4; border: solid 1px #006ea4; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #006ea4;">Restaurar Contraseña</a> </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
            </table>
		'
	],
	// Registro de usuario
	'mail-registration' => [
		'priority' => 1,
		'subject' => 'Registro de Usuario',
		'body' => '
			<p>Hola {name}</p>
			<p>Gracias por registrarte en Promo Bactrovet. Hacé clic en el siguiente botón para activar tu cuenta.</p>
			<br>
			<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                <tbody>
                  <tr>
                    <td align="left"
                      style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                      <table border="0" cellpadding="0" cellspacing="0"
                        style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                        <tbody>
                          <tr>
                            <td
                              style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #3498db; border-radius: 5px; text-align: center;">
                              <a href="{href}" target="_blank"
                                style="display: inline-block; color: #ffffff; background-color: #006ea4; border: solid 1px #006ea4; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #006ea4;">Activar
                                cuenta</a> </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
            </table>
		'
	],
	'mail-invoice-aproved' => [
		'priority' => 1,
		'subject' => '{aprovation} de Factura',
		'body' => '
			<h4>Hola {name}</h4>
			<p>Te informamos que tu factura <b>{numinvoice}</b> ha sido <b>{aproved}</b>.</p>
		'
	]
];