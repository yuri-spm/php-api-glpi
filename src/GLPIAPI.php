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

    public function initSession()
    {


        $headers = [
            'app-token' => $this->appToken,
            'Authorization' => $this->password
        ];

        $response = api_session($this->apiUrl, $headers);

        return $response;
    }

    public function killSession()
    {
      
        $url = $this->apiUrl . '/killSession';

        $headers = array(
            'app-token: ' . $this->appToken,
            'Session-Token:' .$this->sessionToken,
            'Authorization: Basic Z2xwaTouQURNX1MzcnYxYzMu',
        );

        $response =  api_session($url, $headers);

        $jsonData = json_decode($response, true);

        if ($jsonData === null) {
            echo 'Error decoding JSON response: ' . json_last_error_msg();
            return null;
        }

        return $response;
    }
    public function getSessionToken()
    {
        $url = $this->apiUrl . '/initSession';
        $headers = array(
            'app-token: ' . $this->appToken,
            'Authorization: Basic Z2xwaTouQURNX1MzcnYxYzMu',
        );

        $response =  api_session($url, $headers);

        $jsonData = json_decode($response, true);

        if ($jsonData === null) {
            echo 'Error decoding JSON response: ' . json_last_error_msg();
            return null;
        }

        if (isset($jsonData['session_token'])) {
            $this->sessionToken =  $jsonData['session_token'];
            return $this->sessionToken;
        } else {
            echo 'Session token not found in response.';
            return null;
        }
    }

    public function request($custonUrl, $params = '')
    {
        if($params !== ''){
            $url = $this->apiUrl .'/'. $custonUrl .'/'.$params;
        }else {
            $url = $this->apiUrl .'/'. $custonUrl;
        }    

        $headers = array(
            'app-token: ' . $this->appToken,
            'Session-Token:' .$this->sessionToken,
            'Authorization: Basic Z2xwaTouQURNX1MzcnYxYzMu',
        );

        $response =  api_session($url, $headers);
        return $response;

    }

    public function addItem($custonUrl, $params, $data = [])
    {
        if($params !== ''){
            $url = $this->apiUrl .'/'. $custonUrl .'/'.$params;
        }else {
            $url = $this->apiUrl .'/'. $custonUrl;
        } 
        
        $inputData = json_encode($data);
        $headers = array(
            'app-token: ' . $this->appToken,
            'Session-Token:' .$this->sessionToken,
            'Authorization: Basic Z2xwaTouQURNX1MzcnYxYzMu',
            'Content-Type: application/json',
        );

        $response = api_createrItem($url, $headers, $inputData);
        return $response;

    }

    public function updateItem($custonUrl, $params, $data = [])
    {
        if($params !== ''){
            $url = $this->apiUrl .'/'. $custonUrl .'/'.$params;
        }else {
            $url = $this->apiUrl .'/'. $custonUrl;
        } 
        
        $inputData = json_encode($data);
        $headers = array(
            'app-token: ' . $this->appToken,
            'Session-Token:' .$this->sessionToken,
            'Authorization: Basic Z2xwaTouQURNX1MzcnYxYzMu',
            'Content-Type: application/json',
        );

        $response = api_updateItem($url, $headers, $inputData);
        return $response;

    }

    public function deleteItem($custonUrl, $params)
    {
        if($params !== ''){
            $url = $this->apiUrl .'/'. $custonUrl .'/'.$params;
        }else {
            $url = $this->apiUrl .'/'. $custonUrl;
        } 
        
      
        $headers = array(
            'app-token: ' . $this->appToken,
            'Session-Token:' .$this->sessionToken,
            'Authorization: Basic Z2xwaTouQURNX1MzcnYxYzMu',
            'Content-Type: application/json',
        );

        $response = api_deleteItem($url, $headers);
        return $response;

    }

}
