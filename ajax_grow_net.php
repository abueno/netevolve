<?php 
	session_start();
	include_once('functions.php');
	
	$current_net = $_SESSION['current_net'];
	
	if (isset($_GET['m']) && $_GET['m']) {
		$m = $_GET['m'];
	}
	else {
		$m = 1;
	}
	if (isset($_GET['c']) && $_GET['c']) {
		$c = $_GET['c'];
	}
	else {
		$c = 0.2;
	}
	
	$response = add_node($current_net, $c, $m);
	
	echo json_encode($response);
?>