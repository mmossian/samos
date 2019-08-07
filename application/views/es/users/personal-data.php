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
<form class="ui form" method="post" action="<?php echo $this->app_router->route('updatepersonaldata') ?>">
	<input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>">
	<?php if(isset($mainPhone)): ?>
		<input type="hidden" name="id_phone" value="<?php echo $mainPhone->id_phone ?>">
	<?php endif ?>
	<div class="ui two column grid">
		<div class="column">
			<div class="ui card fluid">
				<div class="content">
					<div class="header">Datos Personales</div>
					<div class="meta">(*) Campos Requeridos</div>
					<div class="description">
						<div class="field required">
							<label>Nombre</label>
							<div class="ui left icon input">
								<i class="id card icon"></i>
								<input
									type="text"
									name="first_name"
									autocomplete="off"
									maxlength="20"
									value="<?php echo empty($this->set_values->set('first_name')) ? $this->init->user->first_name : $this->set_values->set('first_name') ?>"
								>
							</div>
						</div>
						<div class="field required">
							<label>Apellido</label>
							<div class="ui left icon input">
								<i class="id card icon"></i>
								<input
									type="text"
									name="last_name"
									autocomplete="off"
									maxlength="20"
									value="<?php echo empty($this->set_values->set('last_name')) ? $this->init->user->last_name : $this->set_values->set('last_name') ?>"
								>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="column">
			<div class="ui card fluid">
				<div class="content">
					<div class="header">Tel&eacute;fono</div>
					<div class="meta">(*) Campos Requeridos</div>
					<div class="description">
						<div class="field required">
							<label>Prinicpal</label>
							<div class="ui labeled input">
								<select class="ui search selection dropdown" name="phone_prefix">
									<?php foreach($prefixes as $c): ?>
										<?php $selected = $c->phone == $phone_prefix ? 'selected="selected"' : '' ?>
										<option value="<?php echo $c->phone ?>" data-iso="<?php echo $c->iso ?>" <?php echo $selected ?>>
											<?php echo $c->phone ?> - <?php echo $c->country ?>
										</option>
									<?php endforeach ?>
								</select>
								<input
									type="text"
									name="phone_number"
									maxlength="12"
									autocomplete="off"
									value="<?php echo empty($this->set_values->set('phone_number')) ? $this->init->user->phone_number : $this->set_values->set('phone_number') ?>"
								>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="ui divider hidden"></div>
	<button type="submit" class="ui button grey fluid big" id="btn-update">Actualizar</button>
</form>