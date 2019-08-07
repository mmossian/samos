<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	----------------------------------------------------------------------------------------
	Modal politicas de privacidad y terminos de uso
	Location: application/views/es/public
	----------------------------------------------------------------------------------------
*/
?>
<div class="ui modal fullscreen" id="modal-policies">
	<i class="ui icon close"></i>
	 <div class="content">
			<div class="ui top attached tabular menu" id="tabs-policies">
				<div class="item active" data-tab="tab-privacy">Pol&iacute;tica de Privacidad</div>
				<div class="item" data-tab="tab-terms">T&eacute;rminos de Uso</div>
			</div>
			<div class="ui bottom attached tab segment active" data-tab="tab-privacy">
				<h1>aqui va la politica de privacidad</h1>
			</div>
			<div class="ui bottom attached tab segment" data-tab="tab-terms">
				<h1>aqui van los terminos de uso</h1>
			</div>
	 </div>
</div>