<?php

require_once ('src/GLPIApi.php');



$apiUrl = 'url';
$username = 'user';
$password = 'senha';
$apptoken = 'apptoken';

$glpiApi = new GLPIApi($apiUrl, $username, $password, $apptoken);

echo $glpiApi->initSession();

