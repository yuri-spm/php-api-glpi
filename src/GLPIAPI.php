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

        // Set the headers for the API request
        $headers = [
            'app-token' => $this->appToken,
            'Authorization' => $this->password
        ];

        // Create a new cURL session
        $response = api_session($this->apiUrl, $headers);

        return $response;
    }

    // End the current session
    public function killSession()
    {
        // Set the URL for the API request to end the session dlfj34hc3kc0fbg2uhm10v4m24
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

    public function request($custonUrl, $params = '', $customRequest = 'GET',)
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

        $response =  api_session($url, $headers, $customRequest);
        return $response;

    }
}
