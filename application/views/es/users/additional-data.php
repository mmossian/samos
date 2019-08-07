<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Vista pagina datos personales (primera vez)
|--------------------------------------------------------------------------
|
*/
?>
<?php $this->load->view('es/message') ?>
<form class="ui form" method="post" action="<?php echo $this->app_router->route('updateadditionaldata') ?>">
	<input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>">
	<input type="hidden" name="additionals_phones" value='<?php echo $additionalPhones ?>'>
	<input type="hidden" name="additionals_emails" value='<?php echo $additionalEmails ?>'>
	<div class="ui two column grid">
		<div class="column">
			<div class="ui card fluid">
				<div class="content">
					<div class="header">Correos Adicionales</div>
					<div class="meta">
						<div class="ui list">
							<div class="item"><i class="info icon"></i> Podr&aacute;s agregar hasta <?php echo $maxEmails ?> correos adicionales.</div>
							<div class="item"><i class="info icon"></i> Todos los documentos que generes ser&aacute;n enviados con copia a los correos que agregues.</div>
						</div>
					</div>
					<div class="description">
						<a class="ui button mini" id="btn-add-additional-email">
							<i class="envelope icon"></i> Agregar Correo
						</a>
						<div id="additional-emails" data-max-emails="<?php echo $maxEmails ?>"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="column">
			<div class="ui card fluid">
				<div class="content">
					<div class="header">Tel&eacute;fonos Adicionales</div>
					<div class="meta">
						<div class="ui list">
							<div class="item"><i class="info icon"></i> Podr&aacute;s agregar hasta <?php echo $maxPhones ?> tel&eacute;fonos adicionales.</div>
							<div class="item"><i class="info icon"></i>Los tel&eacute;fonos agregados ser&aacute;n adjuntados a los documentos que generes como informaci&oacute;n extra.</div>
						</div>
					</div>
					<div class="description">
						<a class="ui button mini" id="btn-add-additional-phone">
							<i class="phone icon"></i> Agregar Tel&eacute;fono
						</a>
						<div id="additional-phones" data-max-phones="<?php echo $maxPhones ?>" ></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="ui divider hidden"></div>
	<button type="submit" class="ui button grey big fluid" id="btn-save-additionals">Actualizar</button>
</form>

<div id="hidden-emails" class="display-none">
	<div class="field">
		<div class="ui divider hidden"></div>
		<div class="ui small right labeled input">
			<input type="email" placeholder="Correo Adicional">
			<a class="ui button red btn-delete-email"><i class="trash icon"></i></a>
		</div>
		<div class="ui segment error-msg display-none border-none" style="padding: 0">
			<span class="ui text inverted red"><i class="exclamation triangle icon"></i> Ingresa un correo v&aacute;lido</span>
		</div>
	</div>
</div>

<div id="hidden-phones" class="display-none">
	<div class="field">
		<div class="ui divider hidden"></div>
		<div class="ui small labeled input">
			<select class="ui search selection dropdown">
				<?php foreach($prefixes as $c): ?>
					<?php $selected = $c->phone == $this->init->user->phone_prefix ? 'selected="selected"' : '' ?>
					<option value="<?php echo $c->phone ?>" <?php echo $selected ?>>
						<?php echo $c->phone ?> - <?php echo $c->country ?>
					</option>
				<?php endforeach ?>
			</select>
			<input type="text" placeholder="Tel&eacute;fono Adicional">
			<a class="ui button red btn-delete-phone"><i class="trash icon"></i></a>
		</div>
		<div class="ui segment error-msg display-none border-none" style="padding: 0">
			<span class="ui text inverted red"><i class="exclamation triangle icon"></i> El tel&eacute;fono debe contener solo d&iacute;gitos y debe ser mayor a 5 y menor a 12 caracteres.</span>
		</div>
	</div>
</div>