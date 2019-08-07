<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Vista pagina steps (primera vez)
|--------------------------------------------------------------------------
|
*/
?>
<div class="ui grid">
	<div class="four wide column">
		<div class="ui tablet stackable steps vertical">
			<div class="step" id="step-home">
				<i class="id card icon"></i>
				<div class="content">
					<div class="title">Datos Contacto</div>
					<div class="description">Ingresa tus datos</div>
				</div>
			</div>
			<div class="step" id="step-additional-data">
				<i class="address book icon"></i>
				<div class="content">
					<div class="title">Datos Adicionales</div>
					<div class="description">Datos adicionales asociados a tu cuenta</div>
				</div>
			</div>
			<div class="step" id="step-password-data">
				<i class="lock icon"></i>
				<div class="content">
					<div class="title">Contrase&ntilde;a</div>
					<div class="description">Cambiar Contrase&ntilde;a</div>
				</div>
			</div>
			<div class="step" id="step-company">
				<i class="building icon"></i>
				<div class="content">
					<div class="title">Empresa</div>
					<div class="description">Ingresa datos de tu empresa</div>
				</div>
			</div>
			<div class="step" id="step-location">
				<i class="globe icon"></i>
				<div class="content">
					<div class="title">Ubicaci&oacute;n</div>
					<div class="description">Ingresa tu ubicaci&oacute;n</div>
				</div>
			</div>
			<div class="step" id="step-colaborators">
				<i class="users icon"></i>
				<div class="content">
					<div class="title">Colaboradores</div>
					<div class="description">Registrar colaboradores asociados.</div>
				</div>
			</div>
			<div class="step" id="step-user-image">
				<i class="image icon"></i>
				<div class="content">
					<div class="title">Im&aacute;gen</div>
					<div class="description">Ingresa tu im&aacute;gen o logo empresarial</div>
				</div>
			</div>
			<div class="step" id="step-settings">
				<i class="cogs icon"></i>
				<div class="content">
					<div class="title">Opciones</div>
					<div class="description">Selecciona tus opciones</div>
				</div>
			</div>
		</div>
	</div>
	<div class="twelve wide column">
		<?php $this->load->view($activeView) ?>
	</div>
</div>