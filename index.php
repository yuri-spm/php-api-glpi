<?php

require_once ('src/GLPIAPI.php');


// Exemplo de uso:
$apiUrl = 'url';
$username = 'user';
$password = 'senha';
$apptoken = 'app-token';

$glpiApi = new GLPIApi($apiUrl, $username, $password, $apptoken);
var_dump($glpiApi);
if ($glpiApi->login()) {
    
    $sessionToken = $glpiApi->getSessionToken();
    var_dump($sessionToken);


    
} else {
    echo "Falha na autenticação";
}