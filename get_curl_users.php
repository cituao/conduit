<?php

$service_url = 'https://uao-sandbox.mrooms.net/blocks/conduit/webservices/rest/user.php';

$curl=curl_init($service_url);
$curl_post_data = array('token'=>'91e2@45$28hy67','method'=>'get_user', 'username'=>'guest');
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, array('token'=>'91e2@45$28hy67','method'=>'get_user', 'value'=>'carestrepo', 'field'=>'username'));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_response = curl_exec($curl);
if ($curl_response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('error occured during curl exec. Additioanl info: ' . var_export($info));
}
curl_close($curl);
print_r($curl_response);
?>