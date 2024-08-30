# Integration Code with GLPi API 🚀

If you liked the repository, please add a star to help out.

This test program was designed to perform various essential functionalities using the GLPI API.

## ➡️ Installation

1. Install the program inside the /var/www/html folder or analyze the directory where PHP is installed for rendering.
2. Execute the composer dump-autoload command to download the necessary libraries.

```shell
composer dump-autoload
```


## ➡️ Code Functionalities

1. **Initiate session:** initSession();

```php
$apiUrl    = 'url';
$userToken = 'userToken';
$appToken  = 'appToken';


$glpiApi = new GLPIApi($apiUrl, $userToken, $appToken);
$sessionData = $glpiApi->initSession();

ob_start();
var_dump($sessionData);
$varDumpOutput = ob_get_clean();

GLPIApi::render($varDumpOutput);
```
2. **End sessão:** killSession()

```php
$killSessionData = $glpiApi->killSession();
ob_start();
var_dump($killSessionData);
$killSessionOutput = ob_get_clean();

GLPIApi::render($killSessionOutput);
```

3. **Request:** requestItem()

```php
$findTicket = $glpiApi->requestItem('Ticket',9);
ob_start();
var_dump($findTicket);
$findTicketOutput = ob_get_clean();

GLPIApi::render($findTicketOutput);
```

4. **Add:** addItem()

```php
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
```


5. **Update:** updateItem()
```php
$data = [
    "input" =>  [
       "_users_id_requester" => 6
   ]
];
$updateTicket = $glpiApi->updateItem('Ticket',2406200096, $data);
ob_start();
var_dump($updateTicket);
$updateTicketOutput = ob_get_clean();

GLPIApi::render($updateTicketOutput);
```

6. **Soft delete (move to trash):** deleteItem()
```php
$deleteTicket = $glpiApi->deleteItem('Ticket', 2406200096);
ob_start();
var_dump($deleteTicket);
$deleteTicketOutput = ob_get_clean();

GLPIApi::render($deleteTicketOutput);
```
7. **Hard delete (permanetly):** purgeItem()
```php
$purgeTicket = $glpiApi->purgeItem('Ticket', 2406200096);
ob_start();
var_dump($purgeTicket);
$purgeTicketOutput = ob_get_clean();

GLPIApi::render($purgeTicketOutput);
```
8. **Document submission:** sendDocuments()
```php
$file = 'src/files/support3.png';
$sendDocuments = $glpiApi->sendDocuments('Document', $file, 'Suporte.png');

ob_start();
var_dump($sendDocuments);
$sendDocumentsOutput = ob_get_clean();

GLPIApi::render($sendDocumentsOutput);
```




#glpi #api #php
