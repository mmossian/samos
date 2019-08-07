<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	----------------------------------------------------------------------------------------
	Fragmento vista formulario cambio contrasena
	Location: application/views/es/users
	----------------------------------------------------------------------------------------
*/
?>
<div id="container">
	<div class="ui segment inverted container">
		<div class="ui header">
			<img class="ui top aligned small image left floated" src="<?php echo $this->init->appLogo ?>">
			<h1>
				Reseteo de Contrase&ntilde;a <?php echo $this->init->appName ?>
			</h1>
		</div>
	</div>
	<div class="ui segment border-none container">
		<div class="ui orange message">
			<ul>
				<li>Haz click en el bot&oacute;n <b>Generar Contrase&ntilde;a</b>.</li>
				<li>La misma ser&aacute; autom&aacute;ticamente copiada a tu porta papeles o copiala manualmente.</li>
				<li>Haz click en el bot&oacute;n <b>Resetear Contrase&ntilde;a</b> y utilizala para ingresar a la aplicaci&oacute;n.</li>
			</ul>
		</div>
		<div class="ui divider hidden"></div>
		<form class="ui form" method="post" action="<?php echo $this->app_router->route('updatepassworddata') ?>">
			<input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>">
			<input type="hidden" name="id_user" value="<?php echo $id_user ?>">
			<input type="hidden" name="token" value="<?php echo $token ?>">
			<input type="hidden" name="rndpwd">
			<div class="ui error message">
				<div class="header">Error !!!</div>
			</div>
			<div class="field">
				<div class="ui action input disabled">
					<input type="text" id="random-pwd" placeholder="Click en el bot&oacute;n Resetear Contrase&ntilde;a">
					<a class="ui button black" id="btn-random-pwd"><i class="random icon"></i> Generar Contrase&ntilde;a</a>
				</div>
				<div class="ui divider hidden"></div>
				<span class="display-none" id="copied">
					<span class="ui text red large font-bold"></span> Copiada !!!
				</span>
			</div>
			<div class="ui divider hidden"></div>
			<div class="field required">
				<div class="g-recaptcha" data-sitekey="6LdhwncUAAAAAE3-r-M4PjeOFi4gcYmt7IaycPkq" data-size="normal" data-theme="light"></div>
			</div>
			<button type="submit" class="ui button big grey fluid" id="btn-reset-pwd">Resetear Contrase&ntilde;a</button>
		</form>
	</div>
</div>