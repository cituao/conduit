<?php
/* *****************************************
   script para crear usuario en el moodlerooms
   de pruebas
   
   Url: https://uao-sandbox.mrooms.net/
***************************************** */
include 'scheme_conduit_course.php';

$service_url = 'https://uao-sandbox.mrooms.net/blocks/conduit/webservices/rest/course.php';

// personalice el array con el usuario a crear
$data_course = array(
    "shortname" => "curso_prueba_600",
    "fullname" => "Curso prueba 600",
	"category" => "7");
// crea un objeto simplexml y carga schema xml tipo user
$xml_course = new SimpleXMLElement($xmlstr);

// cambiamos los valores elementos con los datos de usuario a crear
//$xml_user->datum->mapping[0][0] = $data["username"];
$xml_course->datum->mapping[0][0] = $data_course["shortname"];
$xml_course->datum->mapping[1][0] = $data_course["fullname"];
$xml_course->datum->mapping[2][0] = $data_course["category"];

// convierte objeto simpleXML en strign
$xml_course_str = $xml_course->asXML();

$token = FALSE;
$token =  getenv('TOKEN_MR');
if ($token) {
    $curl=curl_init($service_url);
    $curl_post_data = array('token'=>$token,'method'=>'handle', 'xml'=>$xml_course_str);
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
	// convertimos el xml en un objeto de simpleXML
	
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
