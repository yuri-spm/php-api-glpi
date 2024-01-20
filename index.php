<?php

require_once ('src/GLPIApi.php');



$apiUrl = 'http://209.126.12.158:8089/apirest.php';
$username = 'glpi';
$password = '.ADM_S3rv1c3.';
$apptoken = 'CNSmpF4sLEHYvbOMN8AibrfuVgvEG1ejdBGQl0E9';

$glpiApi = new GLPIApi($apiUrl, $username, $password, $apptoken);
//var_dump($glpiApi);

echo $glpiApi->initSession();

//echo $glpiApi->getTicket(1);