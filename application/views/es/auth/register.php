<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Formulario de registro pagina publica
|--------------------------------------------------------------------------
|
*/
?>
<form class="ui form" id="frm-register" method="post" action="<?php echo $this->app_router->route('registersend') ?>">
	<input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>">
	<!-- Tipo Usuario -->
	<div class="field required">
		<label>Tipo de Usuario</label>
		<select name="user_role" class="ui dropdown">
			<option value="user" selected="selected">Usuario</option>
			<option value="assoc">Transportista</option>
		</select>
	</div>
	<!-- Listado Paises -->
	<div class="field required">
		<label>Pa&iacute;s</label>
		<select class="ui fluid search selection dropdown" name="country">
			<?php foreach($countries as $c): ?>
				<?php $selected = $c->iso === $activeCountry ? 'selected="selected"' : '' ?>
				<option value="<?php echo $c->iso ?>" <?php echo $selected ?> data-flag="<?php echo strtolower($c->iso) ?> flag">
					<?php echo $c->country ?>
				</option>
			<?php endforeach ?>
		</select>
	</div>
	<!-- Email Usuario -->
	<div class="field required">
		<label>Correo Electr&oacute;nico</label>
		<div class="ui left icon input">
			<i class="envelope icon"></i>
			<input type="email" name="email" autofocus autocomplete="off" value="<?php echo $this->set_values->set('email') ?>">
		</div>
	</div>
	<div class="fields">
		<div class="eight wide field required">
			<label>Nombre</label>
			<div class="ui left icon input">
				<i class="id card icon"></i>
				<input type="text" name="first_name" autocomplete="off" value="<?php echo $this->set_values->set('first_name') ?>">
			</div>
		</div>
		<div class="eight wide field required">
			<label>Apellido</label>
			<div class="ui left icon input">
				<i class="id card icon"></i>
				<input type="text" name="last_name" autocomplete="off" value="<?php echo $this->set_values->set('last_name') ?>">
			</div>
		</div>
	</div>
	<div class="field required">
		<div class="g-recaptcha" data-sitekey="6LdhwncUAAAAAE3-r-M4PjeOFi4gcYmt7IaycPkq" data-size="normal" data-theme="light"></div>
	</div>
	<div class="ui font-italic font-bold">
		<p>Al registrarte aceptas nuestra <a href="#" id="btn-show-policies">Pol&iacute;tica de Privacidad y T&eacute;rminos de Uso</a></p>
	</div>
</form>
<div class="ui divider"></div>
<button type="button" class="ui button grey big fluid" id="btn-show-resume">Registrarse</button>