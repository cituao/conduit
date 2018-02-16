<?php
include 'scheme_conduit_user.php';

$data = new SimpleXMLElement($xmlstr);

//var_dump($data);
//$data->datum->mapping[0]='damarquez';
$username = $data->datum->mapping[0];
$nombre = $data->datum->mapping[1];
$apellido = $data->datum->mapping[2];
$email = $data->datum->mapping[3];
$passwd = $data->datum->mapping[4];
$method_auth = $data->datum->mapping[4];
print_r($username);
echo $nombre;
echo $apellido;
echo $email;
echo $passwd;
echo $method_auth;
?>