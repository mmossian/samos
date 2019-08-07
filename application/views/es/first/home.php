<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Vista pagina home (primera vez)
|--------------------------------------------------------------------------
|
*/
?>
<div class="ui segment border-none container" id="container">
	<div class="ui header text centered">
		<span class="ui big text">Datos de Contacto</span><br>
		A trav&eacute;s de los siguientes pasos te ayudaremos a configurar la aplicaci&oacute;n.
	</div>
	<a href="<?php echo $this->app_router->route($btnNextHref) ?>" class="ui button teal <?php echo $btnNextStatus ?> ">Siguiente <i class="angle double right icon"></i></a>
	<div class="ui divider hidden"></div>
</div>
<div class="ui divider hidden"></div>
<div class="ui segment container fluid border-none">
	<?php $this->load->view('es/first/steps') ?>
</div>