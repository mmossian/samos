<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	----------------------------------------------------------------------------------------
	Modal recuperacion contrasenia
	Location: application/views/es/auth
	----------------------------------------------------------------------------------------
*/
?>
<div class="ui modal tiny" id="modal-fpwd">
	 <i class="close icon"></i>
	 <div class="ui header"><i class="lock icon"></i> Reseteo de Contrase&ntilde;a</div>
	 <div class="content">
		<div class="ui info message">
			<div class="header">Atenci&oacute;n</div>
			<ul>
				<li>Un email ser&aacute; enviado a tu direcci&oacute;n de correo electr&oacute;nico.</li>
				<li>Tendr&aacute;s <?php echo $this->config->item('app-validation-duration') ?> horas para validar tu nueva contrase&ntilde;a.</li>
				<li>Pasado ese per&iacute;odo deber&aacute;s requerirla nuevamente</li>
			</ul>
		</div>
	 	<form class="ui form huge" id="frm-fpwd" method="post" action="<?php echo $this->init->baseUrl ?>index.php/fpwd">
	 		<input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>">
	 		<div class="ui error message"></div>
	 		<div class="field required">
				<label>Correo Electr&oacute;nico</label>
				<div class="ui left icon input">
					<i class="envelope icon"></i>
					<input name="email_fpwd" placeholder="Correo Electr&oacute;nico" type="email" autocomplete="off">
				</div>
			</div>
			<div class="ui huge buttons fluid">
				<button type="submit" class="ui primary button" id="btn-forgot-pwd"><i class="envelope icon"></i> Enviar</button>
			</div>
	 	</form>
	 </div>
</div>