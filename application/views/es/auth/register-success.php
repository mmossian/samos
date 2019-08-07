<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	----------------------------------------------------------------------------------------
	Fragmento vista registro expirado
	Location: application/views/es/auth
	----------------------------------------------------------------------------------------
*/
?>
<div class="ui segment inverted green container">
	<div class="ui header">
		<img class="ui top aligned small image left floated" src="<?php echo $this->init->appLogo ?>">
		<h1>
			<small><?php echo $this->init->appName ?></small>
			Has validado correctamente tus datos. Tu usuario ha sido activado.
		</h1>
	</div>
</div>
<div class="ui divider hidden"></div>
<div class="ui segment container">
	<div class="ui active inverted dimmer">
		<div class="ui text loader huge">Aguarda Redirigiendo ....</div>
	</div>
	<p></p><p></p><p></p>
</div>