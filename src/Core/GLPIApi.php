<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class GLPIApi extends Client
{
    private $apiUrl;
    private $username;
    private $password;
    private $appToken;
    private $sessionToken;
    
    /**
     * __construct
     *
     * @param  mixed $apiUrl
     * @param  mixed $username
     * @param  mixed $password
     * @param  mixed $appToken
     * @param  mixed $sessionToken
     * @return void
     */
    public function __construct($apiUrl, $username, $password, $appToken, $sessionToken = '')
    {
        $this->apiUrl = $apiUrl;
        $this->username = $username;
        $this->password = $password;
        $this->appToken = $appToken;
        $this->sessionToken = $sessionToken;
    }
    
    /**
     * initSession
     *
     * @return void
     */
    public function initSession()
    {
        $client = new Client();

        $headers = [
            'Authorization' => $this->appToken,
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        $body = json_encode([
            'app_token' => $this->appToken,
            'username' => $this->username,
            'password' => $this->password
        ]);

        $uri =  $this->apiUrl . '/initSession';

        $request = new Request('POST', $uri, $headers, $body);

        $response = $client->sendAsync($request)->wait();

        $this->sessionToken = json_decode($response->getBody());

        if($response->getStatusCode() == 200){
            echo "Conectado com sucesso, seu session token e: ";
        }
       
    }

    public function killSession()
    {
        $client = new Client();

        $headers = [
            'app-token' => $this->appToken,
            'Session-Token' => $this->sessionToken->session_token,
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
          ];

        $body = json_encode([
            'app_token' => $this->appToken
        ]);

        $url = $this->apiUrl . 'killSession';  
          
        $request = new Request('GET', $url, $headers,$body);

        $response = $client->sendAsync($request)->wait();

    }    
    /**
     * getSessionToken
     *
     * @return void
     */
    public function getSessionToken()
    {
        return $this->sessionToken->session_token;
    }

    public function requestItem()
    {

    }

    public function addItem($custonUrl, $params, $data = [])
    {
    }

    public function updateItem($custonUrl, $params, $data = [])
    {
    }

    public function deleteItem($custonUrl, $params)
    {
    }

    public function purgeItem($custonUrl, $params)
    {
    }
}
