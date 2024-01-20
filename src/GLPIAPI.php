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

    public function login()
    {
        $url = $this->apiUrl . '/initSession';

        $data = array(
            'login_name' => $this->username,
            'login_password' => $this->password,
            'app_token' => $this->appToken
        );

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);


        

        $response = curl_exec($ch);
        var_dump($response);

        curl_close($ch);

        $responseData = json_decode($response, true);

        if (isset($responseData['session_token'])) {
            $this->sessionToken = $responseData['session_token'];
            return true;
        } else {
            return false;
        }
    }
    public function getTicket($ticketId)
    {
        $endpoint = "tickets/$ticketId";
        return $this->makeApiRequest($endpoint);
    }

    public function getSessionToken()
    {
        return $this->getSessionToken();
    }
}
?>
