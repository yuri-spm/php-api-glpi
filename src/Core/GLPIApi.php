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

        if ($response->getStatusCode() == 200) {
            return "Conectado com sucesso, seu session token e:" . $this->sessionToken->session_token;
        }
    }

    public function killSession()
    {
        $client = new Client();

        $headers = [
            'app-token' => $this->appToken,
            'Session-Token' => $this->sessionToken->session_token,
        ];


        $url = $this->apiUrl . '/killSession';

        $request = new Request('GET', $url, $headers);

        $response = $client->sendAsync($request)->wait();

        if ($response->getStatusCode() == 200) {
            return "Sessão finalizada " . $this->sessionToken->session_token;
        }
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
    
    /**
     * requestItem
     *
     * @param  mixed $item
     * @param  mixed $params
     * @return void
     */
    public function requestItem($item, $params = null)
    {
        $client = new Client();

        if (isset($params)) {
            $url = $this->apiUrl . '/' . $item . '/' . $params;
        } else {
            $url = $this->apiUrl . '/' . $item;
        }

        $headers = [
            'Session-Token' => $this->sessionToken->session_token,
            'app-token' => $this->appToken,
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        $request = new Request('GET', $url, $headers);
        $response = $client->sendAsync($request)->wait();
        return $response->getBody();
    }

    public function addItem($item, $params = [])
    {
        $client = new Client();

        $url = $this->apiUrl . '/' . $item;

        $headers = [
            'Session-Token' => $this->sessionToken->session_token,
            'app-token'   => $this->appToken,
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        $body = json_encode($params);

        $request = new Request('POST', $url, $headers, $body);

        $response = $client->sendAsync($request)->wait();

        return $response->getBody();
    }

    public function updateItem()
    {
    }

    public function deleteItem()
    {
    }

    public function purgeItem()
    {
    }
}
