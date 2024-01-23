<?php

include_once('Helpers.php');
class GLPIApi
{
    private $apiUrl;
    private $username;
    private $password;
    private $appToken;
    private $sessionToken;

    public function __construct($apiUrl, $username, $password, $appToken, $sessionToken = '')
    {
        $this->apiUrl = $apiUrl;
        $this->username = $username;
        $this->password = $password;
        $this->appToken = $appToken;
        $this->sessionToken = $sessionToken;
    }


    // Initialize a new session
    public function initSession()
    {
        // Make an API request to get the instance data
        $instancia = api($this->apiUrl, $this->username, $this->password, $this->appToken, $this->sessionToken);

        // Set the headers for the API request
        $headers = [
            'app-token' => $this->appToken,
            'Authorization' => $this->password
        ];

        // Create a new cURL session
        $curlSession = api_createCurlSession($instancia->apiUrl, $headers);

        // Execute the cURL session and get the response
        $response = api_executeCurlSession($curlSession);

        // Return the response
        $this->sessionToken = $response;
        return $response;
    }

    // End the current session
    public function killSession()
    {
        // Make an API request to get the instance data
        $instancia = api($this->apiUrl, $this->username, $this->password, $this->appToken, $this->sessionToken);

        // Set the URL for the API request to end the session
        $url = $instancia->apiUrl . '/killSession';

        // Log the URL for debugging purposes
       
        // Set the headers for the API request
        $headers = [
            'app-token' => $this->appToken,
            'Session-Token' => $this->sessionToken,
            'Authorization: Basic Z2xwaTp0ZXN0ZTEyMw==',
        ];

        var_dump($headers);
      
        $curl = api_createCurlSession($url, $headers);
        $response = api_executeCurlSession($curl);

        return $response;

        
    }
}
