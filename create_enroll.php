<?php
/* *****************************************
   script para crear matrícula en el moodlerooms
   de pruebas
   
   Url: https://uao-sandbox.mrooms.net/
***************************************** */
include 'scheme_conduit_enroll.php';

$service_url = 'https://uao-sandbox.mrooms.net/blocks/conduit/webservices/rest/enroll.php';

$data = array(
    "shortname" => "curso_prueba_100",
	"username" => "estudiante5",
	"role" => "student",
	"timestart" => "12-03-2018",
	"timeend" => "12-04-2018");

// crea un objeto simplexml y carga schema xml tipo user
$xml_enroll = new SimpleXMLElement($xmlstr);

// cambiamos los valores elementos con los datos de usuario a crear
$xml_enroll->datum->mapping[0][0] = $data["shortname"];
$xml_enroll->datum->mapping[1][0] = $data["username"];
$xml_enroll->datum->mapping[2][0] = $data["role"];
$xml_enroll->datum->mapping[3][0] = strval(strtotime($data["timestart"]));
$xml_enroll->datum->mapping[4][0] = strval(strtotime($data["timeend"]));

/*
$xml_enroll->datum->mapping[3][0] = strtotime($data["timestart"]);
$xml_enroll->datum->mapping[4][0] = strtotime($data["timeend"]);
*/

// convertir objeto simplexml en string
$xml_enroll_str = $xml_enroll->asXML();

$token = FALSE;
$token =  getenv('TOKEN_MR');
if ($token) {
    $curl=curl_init($service_url);
    $curl_post_data = array('token'=>$token,'method'=>'handle', 'xml'=>$xml_enroll_str);
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