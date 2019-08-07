<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	----------------------------------------------------------------------------------------
	Fragmento vista info contrasenia
	Location: application/views/es/password
	----------------------------------------------------------------------------------------
*/
?>
<div class="ui message border-none">
	<div class="content">
		<ul class="ui list tiny text">
			 <li>
			 	<b>La contrase&ntilde;a deber&aacute; tener un m&iacute;nimo de <?php echo $this->config->item('app-password-len')['min'] ?> y un m&aacute;ximo de <?php echo $this->config->item('app-password-len')['max'] ?> caracteres.</b>
			 </li>
			 <li>Guarda tu contrase&ntilde;a en un lugar seguro.</li>
			 <li>No compartas tu contrase&ntilde;a con nadie.</li>
			 <li>Evita utilizar claves comunes como tu nombre, aniversarios, etc.</li>
		</ul>
		<?php if(isset($this->init->user) AND $this->init->user->user_active == 1): ?>
			<div class="ui orange message">
				<div class="header"><i class="exclamation triangle icon"></i> Importante !!!</div>
				<ul>
					<li>Por seguridad y protecci&oacute;n de tus datos tendr&aacute;s <?php echo $this->config->item('app-max-chpwd-attempts') ?> intentos para cambiar tu contrase&ntilde;a.</li>
					<li>En el caso de error luego de <?php echo $this->config->item('app-max-chpwd-attempts') ?> intentos, tu usuario ser&aacute; desactivado y un email ser&aacute; enviado a tu direcci&oacute;n de correo para que verifiques tu identidad.</li>
				</ul>
			</div>
		<?php endif ?>
	</div>
</div>
<?php $this->load->view('es/message') ?>
<a class="ui button" id="btn-random-pwd">
	<i class="icon random"></i>
	Generar Contrase&ntilde;a Aleatoria
</a>