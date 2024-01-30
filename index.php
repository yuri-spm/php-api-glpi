<?php

require_once ('src/GLPIApi.php');



$apiUrl = 'url';
$username = 'user';
$password = 'senha';
$apptoken = 'apptoken';

$glpiApi = new GLPIApi($apiUrl, $username, $password, $apptoken);

echo $glpiApi->initSession();


$data = [
    "input" =>  [
        "entities_id" => 0,
        "name" => "PC 4",
        "contact_num" => "PC2_GLPI",
        "comment" => "Atualizado via API",
   ]
];

echo "</br>";
 echo $glpiApi->requestItem('Ticket',55);

//$glpiApi->purgeItem('Computer',10);

echo "</br>";
echo $glpiApi->killSession();