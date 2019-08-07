<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Vista principal. Este es el punto de entrada unico
|--------------------------------------------------------------------------
|
*/
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $this->init->appName ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Archivos CSS -->
		<?php if(isset($this->app_router->appRoutes['css'])): ?>
			<?php foreach($this->app_router->appRoutes['css'] as $css): ?>
				<link rel="stylesheet" type="text/css" href="<?php echo $css ?>">
			<?php endforeach ?>
		<?php endif ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->app_router->asset('fomantic/ui/dist/semantic.min.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo $this->app_router->asset('css/common.css') ?>">

		<?php if(isset($this->app_router->appRoutes['sources'])): ?>
			<?php foreach($this->app_router->appRoutes['sources'] as $sources): ?>
				<script src="<?php echo $sources['source'] ?>" <?php echo $sources['params'] ?> ></script>
			<?php endforeach ?>
		<?php endif ?>

	</head>
	<body>
		<!-- Carga las vistas -->
		<?php foreach($this->app_router->appRoutes['views'] as $view): ?>
			<?php $this->load->view($view) ?>
		<?php endforeach ?>

		<!-- Archivos JS -->
		<script src="<?php echo $this->app_router->asset('components/jquery/jquery.min.js') ?>"></script>
		<script src="<?php echo $this->app_router->asset('fomantic/ui/dist/semantic.min.js') ?>"></script>
		<?php if(isset($this->app_router->appRoutes['js'])): ?>
			<?php foreach($this->app_router->appRoutes['js'] as $js): ?>
				<script src="<?php echo $js ?>"></script>
			<?php endforeach ?>
		<?php endif ?>
		<script src="<?php echo $this->app_router->asset('js/globals.js') ?>"></script>
		<script src="<?php echo $this->app_router->asset('js/ajax.js') ?>"></script>
		<script src="<?php echo $this->app_router->asset('js/interface.js') ?>"></script>
		<script>
			var DomRootEl = $(document.body),
				Window = $(window),
				BaseUrl = '<?php echo $this->init->baseUrl ?>',
				CurUrl = '<?php echo $this->init->curUrl ?>',
				Lang = '<?php echo $this->init->appLang ?>',
				First = <?php echo isset($_SESSION[$this->init->sessionNames['user']]) ? $this->init->user->user_first : '""' ?>,
				ActivePage = '<?php echo $activePage ?>',
				ToastMessage = <?php echo isset($_SESSION[$this->init->sessionNames['toast']]) ? json_encode($_SESSION[$this->init->sessionNames['toast']]) : "''" ?>,
				Message = <?php echo isset($_SESSION[$this->init->sessionNames['message']]) ? json_encode($_SESSION[$this->init->sessionNames['message']]) : "''" ?>,
				Processing = '<?php echo $this->lang->line('processing') ?>';
			<?php if(isset($jsParams)): ?>
				<?php foreach($jsParams as $params): ?>
					<?php echo $params ?>
				<?php endforeach ?>
			<?php endif ?>
			$(function(){$(document.body).Interface('<?php echo $interface ?>')})
		</script>
	</body>
</html>