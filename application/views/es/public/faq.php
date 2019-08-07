<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| FAQ pagina publica
|--------------------------------------------------------------------------
|
*/
?>
<div class="ui container fluid" id="faq">
	<div class="ui header">
		<h1><i class="<?php echo $this->menu->topMenuItems['items']['faq']['icon'] ?> icon"></i> Preguntas Frecuentes</h1>
	</div>
</div>

<div class="ui styled fluid accordion">
	<?php foreach($this->lang->line('app-faq') as $faq): ?>
		<div class="title">
			<i class="dropdown icon"></i>
			<?php echo str_replace('%app-name%', $this->init->appName, $faq['title']) ?>
		</div>
		<div class="content">
			<?php echo str_replace('%app-name%', $this->init->appName, $faq['content']) ?>
		</div>
	<?php endforeach ?>
</div>