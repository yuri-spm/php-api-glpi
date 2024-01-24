<?php

require_once ('src/GLPIApi.php');



$apiUrl = 'url';
$username = 'user';
$password = 'senha';
$apptoken = 'apptoken';

$glpiApi = new GLPIApi($apiUrl, $username, $password, $apptoken);

$glpiApi->initSession();
$glpiApi->getSessionToken();
echo $glpiApi->request('listSearchOptions', 'Computer');
$glpiApi->killSession();
