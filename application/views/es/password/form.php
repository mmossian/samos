<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	----------------------------------------------------------------------------------------
	Fragmento vista formulario contrasenia
	Location: application/views/es/password
	----------------------------------------------------------------------------------------
*/
?>
<?php $this->load->view('es/password/info') ?>
<div class="ui divider"></div>
	<?php if(isset($requireCurPwd) AND $requireCurPwd == TRUE): ?>
		<div class="field required">
			<label>Contrase&ntilde;a Actual</label>
			<input type="password" name="curpwd" placeholder="Ingresa tu contrase&ntilde;a actual">
		</div>
	<?php endif ?>
	<div class="field required">
		<label>Nueva Contrase&ntilde;a</label>
		<input type="password" name="newpwd" placeholder="Ingresa tu nueva contrase&ntilde;a" autofocus>
	</div>
	<div class="field required">
		<label>Reingresar</label>
		<input type="password" name="rnewpwd" placeholder="Reingresa contrase&ntilde;a">
	</div>
	<div class="ui divider"></div>
	<button class="ui button big grey fluid" type="submit">Cambiar Contrase&ntilde;a</button>
