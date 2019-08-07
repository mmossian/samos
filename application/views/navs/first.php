<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Menu pagina first time
|--------------------------------------------------------------------------
|
*/
?>
<div class="ui stacked tablet sticky top borderless icon menu" id="<?php echo $this->menu->topMenuItems['id'] ?>">
	<div class="item header">
		<?php if(isset($this->init->appLogo)): ?>
			<img src="<?php echo $this->init->appLogo ?>">
		<?php else: ?>
			<h4><?php echo $this->init->appName ?></h4>
		<?php endif ?>
	</div>
	<div class="item font-italic font-bold">
		Bienvenid@ <?php echo $this->init->user->fullname ?> &nbsp;
		<small>
			(<?php echo $this->lang->line($this->init->user->user_role) ?> - <?php echo $this->lang->line($this->init->user->user_type) ?>)
		</small>
	</div>
	<div class="right menu">
		<?php foreach($this->menu->topMenuItems['items'] as $key => $item): ?>
			<a class="item" id="<?php echo $key ?>" href="<?php echo $item['url'] ?>">
				<?php echo $item['name'] ?> <i class="<?php echo $item['icon'] ?> icon"></i>
			</a>
		<?php endforeach ?>
	</div>
</div>