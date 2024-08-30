<?php

require 'vendor/autoload.php';
require_once 'src/GLPIApi.php';




$apiUrl    = 'url';
$userToken = 'userToken';
$appToken  = 'appToken';


//Create Session

$glpiApi = new GLPIApi($apiUrl, $userToken, $appToken);
$sessionData = $glpiApi->initSession();

ob_start();
var_dump($sessionData);
$varDumpOutput = ob_get_clean();

GLPIApi::render($varDumpOutput);


//Find Ticket

$findTicket = $glpiApi->requestItem('Ticket',9);
ob_start();
var_dump($findTicket);
$findTicketOutput = ob_get_clean();

GLPIApi::render($findTicketOutput);

//Create Ticket
$data = [
    "input" =>  [
        "entities_id" => 0,
        "name" => "Titulo do meu chamado Criado pela API",
        "content" => "Titulo do meu chamado Criado pela API",
        "_users_id_requester" => 1,
   ]
];
$createTicket = $glpiApi->addItem('Ticket', $data);
ob_start();
var_dump($createTicket);
$createTicketOutput = ob_get_clean();

GLPIApi::render($createTicketOutput);



//Update Ticket
$data = [
    "input" =>  [
       "_users_id_requester" => 6
   ]
];
$updateTicket = $glpiApi->updateItem('Ticket',201, $data);
ob_start();
var_dump($updateTicket);
$updateTicketOutput = ob_get_clean();

GLPIApi::render($updateTicketOutput);

//Delete Ticket
$deleteTicket = $glpiApi->deleteItem('Ticket', 2406200096);
ob_start();
var_dump($deleteTicket);
$deleteTicketOutput = ob_get_clean();

GLPIApi::render($deleteTicketOutput);

//Purge Ticket
$purgeTicket = $glpiApi->purgeItem('Ticket', 2406200096);
ob_start();
var_dump($purgeTicket);
$purgeTicketOutput = ob_get_clean();

GLPIApi::render($purgeTicketOutput);

//Send File
$file = 'src/files/support3.png';
$sendDocuments = $glpiApi->sendDocuments('Document', $file, 'Suporte.png');

ob_start();
var_dump($sendDocuments);
$sendDocumentsOutput = ob_get_clean();

GLPIApi::render($sendDocumentsOutput);

//Kill Session
$killSessionData = $glpiApi->killSession();
ob_start();
var_dump($killSessionData);
$killSessionOutput = ob_get_clean();

GLPIApi::render($killSessionOutput);
