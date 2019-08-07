<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Menu pagina publica
|--------------------------------------------------------------------------
|
*/
?>
<div class="ui labeled fixed huge borderless border-none inverted icon menu app-menu" id="<?php echo $this->menu->topMenuItems['id'] ?>">
	<div class="ui container">
		<div class="item header">
			<?php if(isset($this->init->appLogo)): ?>
				<img src="<?php echo $this->init->appLogo ?>">
			<?php else: ?>
				<h4><?php echo $this->init->appName ?></h4>
			<?php endif ?>
		</div>
		<div class="right menu">
			<?php foreach($this->menu->topMenuItems['items'] as $key => $item): ?>
				<?php $href = $item['url'] == '#' ? $item['url'] : $this->app_router->route($item['url']) ?>
				<?php $cls = $item['url'] == '#' ? '' : 'navscroll' ?>
				<a class="item <?php echo $cls ?>" id="menu-<?php echo $key ?>" href="<?php echo $href ?>">
					<i class="<?php echo $item['icon'] ?> icon"></i>
					<?php echo $item['name'] ?>
				</a>
			<?php endforeach ?>
		</div>
	</div>
</div>