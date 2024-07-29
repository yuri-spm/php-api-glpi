<?php

require 'vendor/autoload.php';
require_once 'src/GLPIApi.php';

// O restante do seu código...




$apiUrl = 'url';
$userToken = 'user_token';
$appToken= 'app_token';


$glpiApi = new GLPIApi($apiUrl, $userToken, $appToken);
echo "<pre>";
var_dump($glpiApi->initSession());
echo "</pre>";

// $data = [
//     "input" =>  [
//         "entities_id" => 0,
//         "name" => "PC 4",
//         "contact_num" => "PC2_GLPI",
//         "comment" => "Atualizado via API",
//    ]
// ];

// echo "</br>";
// echo "<pre>";
// var_dump($glpiApi->addItem('Computer',$data));
// echo "</pre>";

echo "</br>";
echo "<pre>";
var_dump($glpiApi->requestItem('Ticket',2406200076));
echo "</pre>";

echo "</br>";
echo "<pre>";
//$glpiApi->purgeItem('Computer',10);
echo "</pre>";

echo "</br>";
echo $glpiApi->killSession();
