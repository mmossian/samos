<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Vista pagina publica
|--------------------------------------------------------------------------
|
*/
?>
<?php $this->load->view('navs/public') ?>
<div class="ui segment border-none container main" id="container">
	<div class="ui container fluid">
		<?php $this->load->view('es/public/steps') ?>
		<div class="ui card fluid">
			<div class="content">
				<div class="header text centered"><i class="edit icon"></i> Registro de Usuario</div>
			</div>
			<div class="content">
				<div class="ui segment font-bold font-italic">
					<ul>
						<li>Completa todos los campos.</li>
						<li>Un email ser&aacute; enviado a tu direcci&oacute;n de correo electr&oacute;nico.</li>
						<li>
							Tendras <?php echo $this->config->item('app-validation-duration') ?> horas para validar tus datos. Pasado ese per&iacute;odo deber&aacute;s volver a registrarte.
						</li>
						<li>Si no ves el correo en tu bandeja de entrada chequea la bandeja SPAM.</li>
					</ul>
				</div>
				<?php if(isset($_SESSION[$this->init->sessionNames['message']])): ?>
					<?php $this->load->view('es/message') ?>
				<?php endif ?>
				<?php $this->load->view('es/auth/register') ?>
			</div>
		</div>
	</div>
	<div class="ui divider hidden"></div>
	<div class="ui container fluid" id="home">
		<div class="ui header">
			<h1>
				<i class="<?php echo $this->menu->topMenuItems['items']['home']['icon'] ?> icon"></i>
				<?php echo $this->menu->topMenuItems['items']['home']['name'] ?>
			</h1>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		</div>
	</div>
	<div class="ui divider hidden"></div>
	<?php $this->load->view('es/public/faq') ?>
</div>

<!-- <div class="ui header segment inverted red">hola mundo</div> -->