<?php
    /*
        Script para cambiar elementos del esquema XML para usuarios de conduit moodlerooms
    */
    include 'scheme_conduit_user.php';

    $data = new SimpleXMLElement($xmlstr);
    // print_r($data);

    $datum = $data->datum;
    //print_r($datum);
    
    // print_r($data->datum->mapping[0]);
    print_r($data->datum->mapping[3]);
    $mapping = $datum->mapping;

    foreach($mapping as $m) {
        switch((string)$m['name']) {
            case 'username':
                printf("username:%s\n", $m);
            break;
            case 'email':
                printf("email:%s\n", $m);
            break;
        }
    }
    // cambia el value del elemento mapping email 
    $data->datum->mapping[3][0]="jamarquez@uao.edu.co";
    print_r((string)$data->datum->mapping[3][0]);

?>