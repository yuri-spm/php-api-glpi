<?php

class GLPIApi
{
    private $apiUrl;
    private $username;
    private $password;
    private $appToken;
    private $sessionToken;

    public function __construct($apiUrl, $username, $password, $appToken)
    {
        $this->apiUrl = $apiUrl;
        $this->username = $username;
        $this->password = $password;
        $this->appToken = $appToken;
        $this->sessionToken = null; 
    }

    function initSession() {

        $instancia = new self($this->apiUrl, $this->username, $this->password, $this->appToken, $this->sessionToken);
        $url = $instancia->apiUrl;
        $headers =[
            'app-token' => $this->appToken,
            'Authorization' => $this->password
        ];
        $curl = curl_init();   
    
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => $headers,
        ));
    
        $instancia->closeSession($curl);
        $response = curl_exec($curl);
    
        
        
        return $response;
    }

    public function closeSession($curl)
    {
        return curl_close($curl);
    }
    
    public function getTicket($ticketId)
    {
        
    }

}

?>
