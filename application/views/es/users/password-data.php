<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	----------------------------------------------------------------------------------------
	Fragmento vista formulario cambio contrasena
	Location: application/views/es/users
	----------------------------------------------------------------------------------------
*/
?>

<form class="ui form big" id="frm-pwd" method="post" action="<?php echo $this->app_router->route('updatepassworddata') ?>">
	<input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>">
	<?php $this->load->view('es/password/form') ?>
</form>