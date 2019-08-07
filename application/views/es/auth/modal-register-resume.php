<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	----------------------------------------------------------------------------------------
	Modal resumen de registro
	Location: application/views/es/auth
	----------------------------------------------------------------------------------------
*/
?>
<div class="ui modal" id="modal-register-resume">
	 <div class="ui header"><i class="edit icon"></i> Resumen de Registro</div>
	 <div class="content">
	 	<div class="ui info icon message">
	 		<i class="exclamation icon"></i>
	 		<div class="content">
	 			<ul>
	 				<li>Chequea atentamente tus datos.</li>
	 				<li>En caso de no ser correctos haz click en <b>Cancelar</b> y cambia los datos en el formulario.</li>
	 				<li>Tu correo electr&oacute;nico ser&aacute; su ID de usuario.</li>
	 			</ul>
	 		</div>
	 	</div>
	 	<div class="ui success message">
	 		<div class="content">
			 	<h4>Te has registrado como: <b><span class="user_role"></span></b></h4>
			 	<h4>Tu Pa&iacute;s: <b><span class="country"></span></b></h4>
			 	<h4>Tu ID de usuario: <b><span class="user_email"></span></b></h4>
			 	<h4>Nombre completo: <b><span class="first_name"></span> <span class="last_name"></span></b></h4>
			 </div>
		</div>
	 </div>

	 <div class="actions">
		<div class="ui primary approve labeled icon button left floated" id="btn-register-new-user">
			Registrarse<i class="checkmark icon"></i>
		</div>
		<div class="ui labeled icon black deny button"><i class="close icon icon"></i>Cancelar</div>
	</div>
</div>