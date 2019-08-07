<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Formulario de login
|--------------------------------------------------------------------------
|
*/
?>
<div class="ui flowing popup bottom center transition hidden" id="login-form">
	<div class="ui header">
		<h4><i class="users icon"></i> Acceso Usuarios</h4>
	</div>
	<div class="ui divider"></div>
	<form class="ui form" id="frm-login" method="post" action="<?php echo $this->app_router->route('login') ?>">
		<input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>">
		<div class="ui error message"></div>
		<div class="field required">
			<div class="ui left icon input">
				<i class="user icon"></i>
				<input type="email" name="user_email" autocomplete="off" placeholder="Correo Electr&oacute;nico">
			</div>
		</div>
		<div class="field required">
			<div class="ui left icon input">
				<i class="lock icon"></i>
				<input type="password" name="user_pwd" placeholder="Contrase&ntilde;a">
			</div>
		</div>

		<div class="ui divider"></div>
		<div class="ui buttons">
			<button type="submit" class="ui button positive"><i class="sign in alternate icon"></i> Acceder</button>
			<div class="or" data-text="o"></div>
			<button type="button" class="ui negative button" id="btn-fpwd"><i class="question circle icon"></i> Olvide mi contrase&ntilde;a</button>
		</div>
	</form>
</div>