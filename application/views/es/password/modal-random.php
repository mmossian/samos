<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	----------------------------------------------------------------------------------------
	Fragmento modal generar contrasenia aleatoria
	Location: application/views/es/password
	----------------------------------------------------------------------------------------
*/
?>
<div class="ui modal big" id="modal-random-pwd">
	 <i class="close icon"></i>
	 <div class="ui header"><i class="random icon"></i> Generaci&oacute;n de Contrase&ntilde;as</div>
	 <div class="content">
	 	<form class="ui form">
		 	<div class="ui stackable three column grid">
		 		<div class="column field">
		 			<label>Tipo</label>
		 			<select name="pwd_type" class="ui selection dropdown">
		 				<option value="alfanum" selected="selected">Alfanum&eacute;rica</option>
		 				<option value="specialchars">Caracteres Especiales</option>
		 			</select>
		 		</div>
		 		<div class="column field">
		 			<label>N&uacute;m Caracteres</label>
		 			<input type="number" name="pwd_len" value="9" min="<?php echo $this->config->item('app-password-len')['min'] ?>" max="<?php echo $this->config->item('app-password-len')['max'] ?>" autofocus>
		 		</div>
		 		<div class="column field">
		 			<label>&nbsp;</label>
		 			<a class="ui button right floated" id="generate-rand-pwd"><i class="random icon"></i> Generar</a>
		 		</div>
		 	</div>
		 	<div class="ui divider"></div>
		 	<div class="ui icon input">
		 		<input type="text" id="pwd-generated">
		 		<i class="copy outline icon link" title="Copiar"></i>
		 	</div>
		 	<small id="pwd-copied" class="display-none">Copiado!!!</small>
		 </form>
	 </div>
	 <div class="actions">
	 	<button type="button" class="ui cancel button" disabled>Usar Contrase&ntilde;a</button>
	 </div>
</div>