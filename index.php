<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#" itemscope itemtype="http://schema.org/LocalBusiness">
<head>
	<title>NetEvolve</title>
	<link rel="StyleSheet" href="styles.css" type="text/css"></link>
	
	<!-- JAVASCRIPT - IMPORTS -->
    <script src='//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' type='text/javascript'></script>
    <script src='//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js' type='text/javascript'></script>
    
    <script src="js/sigma.min.js" type='text/javascript'></script>
    <script src="js/sigma.forceatlas2.js" type='text/javascript'></script>
</head>
<body>
	<div id="top">
		<div id="logo">NetEvolve</div>
		<div id="description">Complex Network Evolution Simulator</div>
	</div>

	<?php
	if (isset($_POST['submitted'])) {
		if (isset($_POST['initialSpeed']) && is_int(intval($_POST['initialSpeed']) ) && intval($_POST['initialSpeed']) > 0) {
			$initialSpeed = intval($_POST['initialSpeed']);
		}
		else {
			$initialSpeed = 1000;
		}
		if (isset($_POST['initialColor']) && preg_match('/^[a-fA-F0-9]{6}$/', $_POST['initialColor'])) {
			$initialColor = $_POST['initialColor'];			
		}
		else {
			$initialColor = "ff0000";
		}
		if (isset($_POST['newNodeColor']) && preg_match('/^[a-fA-F0-9]{6}$/', $_POST['newNodeColor'])) {
			$newNodeColor = $_POST['newNodeColor'];
		}
		else {
			$newNodeColor = "00ff00";
		}
		if (isset($_POST['initialM']) && is_int(intval($_POST['initialM']) ) && intval($_POST['initialM']) > 0) {
			$initialM = intval($_POST['initialM']);
		}
		else {
			$initialM = 3;
		}
		if (isset($_POST['initialC']) && is_int(intval($_POST['initialC']) ) && intval($_POST['initialC']) > 0) {
			$initialC = intval($_POST['initialC']);
		}
		else {
			$initialC = 20;
		}
		$initialC = $initialC / 100.0;
	?>
		<div id="sig"></div>
		<div id="sigmaParent" style="height: 600px; position: relative; background: #000; margin: 0">
		    <div id="sigma" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0;">
		    </div>
		</div>
		Time: <span id="t"></span>
		<button id="increaseSpeed">Increase Speed</button>
		<button id="decreaseSpeed">Decrease Speed</button>
		Current speed: <strong id="currentSpeed"><?php echo $initialSpeed; ?></strong> ms
		<input type="hidden" id="currentSpeedInput" value="<?php echo $initialSpeed; ?>" />
		<input type="hidden" id="m" value="<?php echo $initialM; ?>" />
		<input type="hidden" id="c" value="<?php echo $initialC; ?>" />
		<button id="stopAnimation">Stop</button>
		<button id="resumeAnimation">Resume</button>
		<button id="layoutGraph">Start Layout Animation</button>
		<button id="stopLayoutGraph">Stop Layout Animation</button>
		<br />
		New nodes color: #<input type="text" id="newNodeColor" value="<?php echo $newNodeColor; ?>" />
		<button id="changeNewNodeColor">Change</button>
	<?php } ?>
	
	<div id="middle">
	<?php
	if (isset($_POST['submitted'])) {
		$tmp_name = $_FILES['file']['tmp_name'];
		
		$uploaddir = './uploads/';
		$uploadfile = $uploaddir . basename($_FILES['file']['name']);
		
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			session_start();
			?>
			<?php include_once('functions.php'); ?>
			
			
			<div class="content">
				<?php 
					$file = file($uploadfile);
					$file_string = file_get_contents($uploadfile);
					$net = json_decode($file_string, true);
				?>
				

				<?php $current_net = pre_proccess($net); ?>
				<?php $_SESSION['current_net'] = $current_net; ?>
				<?php include_once('draw_graph_script.php'); ?>
				<?php include_once('display_graph_settings.php'); ?>
			</div>
			
			<?php
		}
		else {
			?>
				<div class="content">
					<h1>Erro no Upload!</h1>
				</div>
			<?php
		}
	}
	else { ?>
	
		<div class="content">
			<form id="fileForm" method="POST" enctype="multipart/form-data">
				<input type="file" name="file" />
				<br /><br />
				Initial Animation Speed: <input type="text" name="initialSpeed" value="1000" /> <strong>ms</strong>
				<br />
				Initial Nodes Color: <strong>#</strong> <input type="text" name="initialColor" value="ff0000" />
				<br />
				New Node Color: <strong>#</strong> <input type="text" name="newNodeColor" value="00ff00" />
				<br />
				Initial M: <input type="text" name="initialM" value="1" />
				<br />
				Initial C: <input type="text" name="initialC" value="20" />
				<br /><br />
				<button type="submit" name="submitted" value="1" class="big">Enviar arquivo</button>
			</form>	
		</div>
		
	<?php } ?>
	</div>
	
	<div id="bottom"></div>
</body>
</html>