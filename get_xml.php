<?php
include 'xmlstr.php';

$peliculas = new SimpleXMLElement($xmlstr);

// echo $peliculas->pelicula[0]->argumento;
echo $peliculas;
?>