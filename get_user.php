<?php
$token = FALSE;
$token =  getenv('TOKEN_MR');
if ($token) {
	$service_url = 'https://uao-sandbox.mrooms.net/blocks/conduit/webservices/rest/user.php';
	$curl=curl_init($service_url);
	$curl_post_data = array('token'=>$token,'method'=>'get_user', 'username'=>'guest');
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, array('token'=>$token,'method'=>'get_user', 'value'=>'david.maquez', 'field'=>'username'));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$curl_response = curl_exec($curl);
	if ($curl_response === false) {
		$info = curl_getinfo($curl);
		curl_close($curl);
		die('error occured during curl exec. Additioanl info: ' . var_export($info));
	}
	curl_close($curl);
	
	// print_r($curl_response);

	$xml_body = simplexml_load_string($curl_response);
	
	$status = $xml_body->get_user->status;
	if ((string)$status == 'success') {
		printf ("SUCCESS!\n");
	} 
	
	if ((string)$status == 'failed') {
		printf ("failed!\n");
	}
	
	
	/*
	$user_xml = $xml_body->get_user->user;
	$json = json_encode($user_xml);
	$user_array = json_decode($json,TRUE);
	$data = array("username" => $user_array['username'], "email" => $user_array['email']);
	var_dump($data);
	*/

} else {
	printf("ERR:token no existe!\n");
}
?>
