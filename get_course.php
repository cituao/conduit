<?php
/* *********************************************************
script para obtener curso de moodlerooms


************************************************************/

// datos del curso a buscar
$curso = array(
    "value" => "curso_prueba_600",
	"field" => "shortname");

$token = FALSE;
$token =  getenv('TOKEN_MR');
if ($token) {
	$service_url = 'https://uao-sandbox.mrooms.net/blocks/conduit/webservices/rest/course.php';
	$curl=curl_init($service_url);
	$curl_post_data = array('token'=>$token,'method'=>'get_course', 'username'=>'guest');
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, array('token'=>$token,'method'=>'get_course', 'value'=>$curso['value'], 'field'=>$curso['field']));
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
	
	// convertir en un objeto simpleXML
	$xml_body = simplexml_load_string($curl_response);
	
	
	$status = $xml_body->get_course->status;
	if ((string)$status == 'success') {
		$course_xml = $xml_body->get_course->course;
		$json = json_encode($course_xml);
		$course_array = json_decode($json,TRUE);
		$data = array("shortname" => $course_array['shortname'], "idnumber" => $course_array['idnumber'], "status" => "success");
	}

	if ((string)$status == 'failed') {
		$message = (string)$xml_body->get_course->response->message;
		$data = array("status" => "failed", "message" => $message);
	}
	
	
} else {
	$data = array("status" => "failed", "message" => "Token no existe");
}
printf("*****ARRAY SWVIRTUAL*****\n");
var_dump($data);
?>
