<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	----------------------------------------------------------------------------------------
	Fragmento vista validacion de registro
	Location: application/views/es/auth
	----------------------------------------------------------------------------------------
*/
?>
<div class="ui segment container">
	<div class="ui header">
		<img class="ui top aligned small image left floated" src="<?php echo $this->init->appLogo ?>">
		<h1><small><?php echo $this->init->appName ?></small> Validaci&oacute;n de Registro</h1>
	</div>
	<div class="ui header">Bienvenid@ <?php echo $name ?></div>
	<div class="ui header">Ingresa la contrase&ntilde;a con la que acceder&aacute;s a la aplicaci&oacute;n.</div>
	<div class="ui header">Una vez que confirmes tu contrase&ntilde;a e identidad, tu usuario ser&aacute; activado.</div>
	<form class="ui form big" id="frm-pwd" method="post" action="<?php echo $this->app_router->route('validateregistrationpwd') ?>">
		<input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>">
		<input type="hidden" name="id_user" value="<?php echo $id_user ?>">
		<input type="hidden" name="token" value="<?php echo $token ?>">
		<?php $this->load->view('es/password/form') ?>
	</form>
</div>