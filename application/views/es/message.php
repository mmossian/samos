<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	----------------------------------------------------------------------------------------
	Fragmento vista mensajes
	Location: application/views/es
	----------------------------------------------------------------------------------------
*/

?>
<?php if(isset($_SESSION[$this->init->sessionNames['message']])): ?>
	<?php $msg =  $_SESSION[$this->init->sessionNames['message']]?>
	<?php $duration = isset($msg['duration']) ? $msg['duration'] : 0 ?>
	<div class="ui <?php echo $msg['cls'] ?> icon message app-message" data-duration="<?php echo $duration ?>">
		<i class="<?php echo $msg['icon'] ?> icon"></i>
		<i class="close icon"></i>
		<div class="content">
			<?php if(isset($msg['header'])): ?>
				<div class="header"><?php echo $msg['header'] ?></div>
			<?php endif ?>
			<p><?php echo $msg['message'] ?></p>
		</div>
	</div>
<?php endif ?>