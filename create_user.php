<?php
/* *****************************************
   script para crear usuario en el moodlerooms
   de pruebas
   
   Url: https://uao-sandbox.mrooms.net/
***************************************** */

include 'scheme_conduit_user.php';

$service_url = 'https://uao-sandbox.mrooms.net/blocks/conduit/webservices/rest/user.php';

// personalice el array con el usuario a crear
$data = array(
    "username" => "invitado5",
	"password" => "Uao.2018",
    "nombre" => "invitado11",
    "apellido" => "invitado11",
    "email" => "invitado11@uao.edu.co",
    "auth" => "manual");
// crea un objeto simplexml y carga schema xml tipo user
$xml_user = new SimpleXMLElement($xmlstr);

// cambiamos los valores elementos con los datos de usuario a crear
//$xml_user->datum->mapping[0][0] = $data["username"];
$xml_user->datum->mapping[0][0] = $data["username"];
$xml_user->datum->mapping[1][0] = $data["password"];
$xml_user->datum->mapping[2][0] = $data["nombre"];
$xml_user->datum->mapping[3][0] = $data["apellido"];
$xml_user->datum->mapping[4][0] = $data["email"];
$xml_user->datum->mapping[5][0] = $data["auth"];


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
	printf("*****XML RESPONSE CONDUIT*****\n");
    print_r($curl_response);
	// la respuesta es un string xml
	// lo convertimos el xml en un objeto de simpleXML
	$xml_response = simplexml_load_string($curl_response);
	
	//obtenemos el status 
	$status = $xml_response->handle->status;
	// $status es un objeto simple XML
	if ((string)$status == 'success') {
		$data = array("status" => "success");
	} else {
		//extraemos el mensaje
		$message = (string)$xml_response->handle->message;
		$data = array("status" => "failed", "message" => $message);
	}
	
} 
else {
    printf("ERR:token no existe [%s]\n", $token);
    // print_r($xml_user);
}
printf("*****ARRAY SWVIRTUAL*****\n");
var_dump($data);
?>
