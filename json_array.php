<?php
	$json_usuario = '{"username":"david.marquez","passwd":"1234"}';
	
	//printf("json_str:%s\n", $json_usuario);
	$array_usuario = json_decode($json_usuario);
	print_r($array_usuario);
?>