<?php

return [
	'message-general-error' => [
		'title' => 'Upppsss !!!',
		'message' => '{error}',
		'displayTime' => 7000,
		'class' => 'error',
		'showProgress' => 'bottom',
    	'classProgress' => 'orange'
	],
	// Mensajes de registros (salvados, eliminados)
	'message-record-saved-ok' => [
		'title' => 'Excelente',
		'message' => 'El registro se ha salvado correctamente.',
		'displayTime' => 7000,
		'class' => 'success',
		'showProgress' => 'bottom',
    	'classProgress' => 'orange'
	],
	'message-record-saved-error' => [
		'title' => 'Error',
		'message' => 'Se ha producido un error al momento de salvar el registro. Por favor inténtalo nuevamente.',
		'displayTime' => 7000,
		'class' => 'error',
		'showProgress' => 'bottom',
    	'classProgress' => 'orange'
	],
	'message-record-deleted-ok' => [
		'title' => 'Excelente',
		'message' => 'El registro ha sido exitosamente eliminado.',
		'displayTime' => 7000,
		'class' => 'success',
		'showProgress' => 'bottom',
    	'classProgress' => 'orange'
	],
	'message-record-deleted-error' => [
		'title' => 'Error',
		'message' => 'El registro no ha podido ser eliminado.',
		'displayTime' => 7000,
		'class' => 'error',
		'showProgress' => 'bottom',
    	'classProgress' => 'orange'
	],
	// Mensajes de correo electronico
	'message-mail-sent-error' => [
		'title' => 'Error',
		'message' => 'El correo no ha podido ser enviado.',
		'displayTime' => 7000,
		'class' => 'error',
		'showProgress' => 'bottom',
    	'classProgress' => 'orange'
	],
	'message-mail-sent-ok' => [
		'title' => 'Bien',
		'message' => 'El correo ha sido enviado a sus destinatarios.',
		'displayTime' => 7000,
		'class' => 'success',
		'showProgress' => 'bottom',
    	'classProgress' => 'olive'
	],
	// Mensajes de registro de usuarios
	'message-registration-ok' => [
		'title' => 'Bien',
		'message' => '<ul>
			<li>Un email ha sido enviado a la dirección {email}.</li>
			<li>Tené en cuenta revisar tu carpeta de correo no deseado.</li>
			<li>Tendrás {signUpConfirmationExpires} horas para confirmar tu registro.</li>
			<li>Pasado ese período deberás volver a registrarte.</li>
			</ul>
		',
		'displayTime' => 0,
		'class' => 'success'
	],
	'message-registration-error' => [
		'title' => 'Error',
		'message' => 'Por favor inténtalo nuevamente',
		'displayTime' => 0,
		'class' => 'error'
	],
	'message-registration-validation-ok' => [
		'title' => 'Bien',
		'message' => '<ul>
			<li>Te has registrado como usuario de nuestra aplicación.</li>
			<li>Ingresa con tu correo electrónico y contraseña.</li>
			</ul>
		',
		'displayTime' => 0,
		'class' => 'success'
	],
	'message-registration-validation-error' => [
		'title' => 'Error !!!',
		'message' => '<ul>
			<li>Tus datos ya han sido validados o tu período de validación ha expirado.</li>
			</ul>
		',
		'displayTime' => 7500,
		'class' => 'error'
	],

	// Mensaje de olvido y actualizacion de contrasenias
	'message-password-validation-ok' => [
		'title' => 'Bien',
		'message' => 'Tu contraseña ha sido exitosamente actualizada.',
		'displayTime' => 0,
		'class' => 'success'
	],
	'message-sent-password-ok' => [
		'title' => 'Bien',
		'message' => '<ul>
			<li>Un email ha sido enviado a la dirección {email}.</li>
			<li>Tené en cuenta revisar tu carpeta de correo no deseado.</li>
			<li>Tendrás {PasswordResetExpires} horas para recuperar tu contraseña.</li>
			<li>Pasado ese período deberás volver a requerirla.</li>
			</ul>
		',
		'displayTime' => 0,
		'class' => 'success'
	],
	'message-sent-password-done' => [
		'message' => 'Un correo ya ha sido enviado a {email}.<br>Chequea tu bandeja de SPAM en caso de que no se encuentre en tu bandeja de entrada.',
		'displayTime' => 8000,
		'class' => 'orange',
		'showProgress' => 'bottom',
    	'classProgress' => 'orange',
	],

	'message-curpassword-not-match' => [
		'title' => 'Error!!',
		'message' => 'La contraseña actual es incorrecta.',
		'displayTime' => 5000,
		'class' => 'error'
	],

	// Mensajes de usuarios
	'message-login-error' => [
		'title' => 'Error de Validación',
		'message' => 'Chequee su nombre de usuario y contraseña.',
		'displayTime' => 5000,
		'class' => 'error',
		'showProgress' => 'bottom',
    	'classProgress' => 'orange'
	],
	'message-user-not-active' => [
		'title' => 'Atención !!!',
		'message' => 'El usuario {email} no se encuentra activo.',
		'displayTime' => 0,
		'class' => 'red',
		// 'showProgress' => 'bottom',
    	// 'classProgress' => 'orange',
	],
	'message-user-not-exists' => [
		'title' => 'Error',
		'message' => 'No existe ningún usuario registrado con esas credenciales.',
		'displayTime' => 5000,
		'class' => 'error',
		'showProgress' => 'bottom',
    	'classProgress' => 'orange'
	],
	'message-user-email-notverified' => [
		'title' => 'Verificación de email',
		'message' => '<p>Debes verificar tu email para iniciar sesión.</p><p>Si no encuentras el correo en tu bandeja de entrada chequea tu bandeja de SPAM</p>',
		'displayTime' => 5000,
		'class' => 'orange',
		'showProgress' => 'bottom',
    	'classProgress' => 'red'
	],
	'message-file-uploaded-ok' => [
		'title' => 'Excelente !!!',
		'message' => 'El archivo ha sido correctamente subido al servidor.',
		'displayTime' => 5000,
		'class' => 'success',
		'showProgress' => 'bottom',
    	'classProgress' => 'orange'
	],
	'message-file-uploaded-error' => [
		'title' => 'Error',
		'message' => 'El archivo no ha podido ser subido al servidor.',
		'displayTime' => 5000,
		'class' => 'error',
		'showProgress' => 'bottom',
    	'classProgress' => 'orange'
	],

	'message-winners-published-error' => [
		'title' => 'Error',
		'message' => 'Los ganadores no han podido ser publicados.',
		'displayTime' => 5000,
		'class' => 'error',
		'showProgress' => 'bottom',
    	'classProgress' => 'orange'
	],

	'message-winners-published-ok' => [
		'title' => 'Excelente !!',
		'message' => 'Los ganadores han sido publicados.',
		'displayTime' => 5000,
		'class' => 'success',
		'showProgress' => 'bottom',
    	'classProgress' => 'orange'
	],

	'message-draw-created-ok' => [
		'title' => 'Excelente !!',
		'message' => 'El sorteo ha sido agregado.',
		'displayTime' => 5000,
		'class' => 'success',
		'showProgress' => 'bottom',
    	'classProgress' => 'orange'
	],

	'message-draw-created-error' => [
		'title' => 'El sorteo no ha podido ser creado',
		'message' => '
			<p>No hay la cantidad de usuarios requeridos para hacer el sorteo.<br>
			Ya ha sido creado un sorteo con el mes y año especificados.</p>
		',
		'displayTime' => 5000,
		'class' => 'error',
		'showProgress' => 'bottom',
    	'classProgress' => 'orange'
	],
];

