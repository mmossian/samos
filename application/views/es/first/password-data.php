<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Vista pagina cambio contrasena (primera vez)
|--------------------------------------------------------------------------
|
*/
?>
<div id="container">
	<div class="ui segment border-none container">
		<div class="ui header text centered">
			<span class="ui big text">Cambiar Contrase&ntilde;a</span><br>
			<span class="ui small text grey">Puedes saltar este paso si no deseas cambiar tu contrase&ntilde;a.</span>
		</div>
		<div class="ui buttons">
			<a class="ui button" href="<?php echo $this->app_router->route($btnPreviousHref) ?>">
				<i class="angle double left icon"></i> Anterior
			</a>
			<div class="or" data-text="o"></div>
			<a class="ui teal button" href="<?php echo $this->app_router->route($btnNextHref) ?>">
				Siguiente <i class="angle double right icon"></i>
			</a>
		</div>

	</div>
	<div class="ui segment border-none container fluid">
		<div class="ui divider hidden"></div>
		<?php $this->load->view('es/first/steps') ?>
	</div>
</div>