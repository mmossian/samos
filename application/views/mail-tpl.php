
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->init->appLang ?>">
	<head>
		<title><?php echo $this->init->appName ?></title>
		<style type="text/css">
			h3{
				font-size: 18px;
			}
			h4{
				font-size: 16px;
			}
			h5{
				font-size: 14px;
			}
			table.tcontainer{
				font-size: 12px;
				border-radius: 5px;
				position: relative;
				background: #fff;
				width: 90%;
				margin-right: 5%;
				margin-left: 5%;
				padding: 0;
				font-family: Arial;
			}
			.header{
				height: 60px;
				padding: 3px;
				color: black;
				font-size: 10px;
				text-indent: 5px
			}
			.footer{
				background-color: #efefef;
				padding: 10px;
				font-size: 14px
			}
			.logo{
				padding: 5px
			}

			.body{
				color: #4a7eb0;
				padding: 10px;
				margin-top: 1px;
			}
			.btn{
				background-color: #efefef;
				color: #4a7eb0;
				padding: 10px;
				border-radius: 3px;
			}
		</style>
	</head>

	<table class="tcontainer">
		<tr class="header">
			<td class="logo"><img src="<?php echo $this->init->appLogo?>" style="width: 60px"></td>
			<td><h4 style="float: left;"><?php echo $this->init->appName ?></h4></td>
		</tr>
		<tr>
			<td class="body"><?=$tplContent?></td>
		</tr>

		<tr>
			<td class="footer">
				<div style="float: left; font-weight: bold">
					<?php echo $tplSignature ?>
				</div>
			</td>
		</tr>
	</table>
</html>