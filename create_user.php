<?php
/* *****************************************
   script para crear usuario en el moodlerooms
   de pruebas
   
   Url: https://uao-sandbox.mrooms.net/
***************************************** */

//datos del usuario


$service_url = 'https://uao-sandbox.mrooms.net/blocks/conduit/webservices/rest/user.php';
$xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<data>
<datum action="create">
<mapping name="username">invitado3</mapping>
<mapping name="nombre">luisa</mapping>
<mapping name="apellido">rondon</mapping>
<mapping name="email">luisa.rondon@uao.edu.co</mapping>
<mapping name="password">12345#Uao</mapping>
<mapping name="auth">manual</mapping>
</datum>
</data>
XML;

$curl=curl_init($service_url);
$curl_post_data = array('token'=>'91e2@45$28hy67','method'=>'handle', 'xml'=>$xml);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
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
