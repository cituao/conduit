<?php
/* *****************************************
   script para crear usuario en el moodlerooms
   de pruebas
   
   Url: https://uao-sandbox.mrooms.net/
***************************************** */

//datos del usuario
//include 'scheme_conduit_user.php';
$xmlstr = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<data>
<datum action="create">
<mapping name="username">invitado4</mapping>
<mapping name="email">invitado4@uao.edu.co</mapping>
<mapping name="auth">manual</mapping>
<mapping name="password">Uao.2018</mapping>
<mapping name="nombre">invitado4</mapping>
<mapping name="apellido">invitado4</mapping>
</datum>
</data>
XML;
$service_url = 'https://uao-sandbox.mrooms.net/blocks/conduit/webservices/rest/user.php';

$data = array(
    "username" => "david.marquez",
    "nombre" => "david alejandro",
    "apellido" => "marquez olascoaga",
    "email" => "david.marquez@uao.edu.co",
    "password" => "1234567890",
    "auth" => "manual");
// crea un objeto simplexml y carga schema xml tipo user
$xml_user = new SimpleXMLElement($xmlstr);

// cambiamos los valores elementos con los datos de usuario a crear
$xml_user->datum->mapping[0][0] = $data["username"];
$xml_user->datum->mapping[1][0] = $data["email"];
$xml_user->datum->mapping[2][0] = $data["auth"];
$xml_user->datum->mapping[3][0] = $data["password"];
$xml_user->datum->mapping[4][0] = $data["nombre"];
$xml_user->datum->mapping[5][0] = $data["apellido"];

$xml_user_str = $xml_user->asXML();

$token = FALSE;
$token =  getenv('TOKEN_MR');
if ($token) {
    $curl=curl_init($service_url);
    $curl_post_data = array('token'=>$token,'method'=>'handle', 'xml'=>$xml_user_str);
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
	
} 
else {
    printf("ERR:token no existe [%s]\n", $token);
    // print_r($xml_user);
}
?>
