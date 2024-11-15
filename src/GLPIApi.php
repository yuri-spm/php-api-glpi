<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class GLPIApi
{
    private $apiUrl;
    private $userToken;
    private $appToken;
    private $sessionToken;

    public function __construct($apiUrl, $userToken, $appToken, $sessionToken = '')
    {
        $this->apiUrl = $apiUrl;
        $this->userToken = $userToken;
        $this->appToken = $appToken;
        $this->sessionToken = $sessionToken;
    }


    public function sendRequest($method, $endpoint, $headers = [], $body = null)
    {
       $client = new Client();
       
       $url = $this->apiUrl . $endpoint;

       $options = [
        'headers' => $headers
       ];

       if($body){
            $options['body'] = json_encode($body);
       }

        try {
            $response = $client->request($method, $url, $options);
            return json_encode([
                'status' => 'success',
                'data' => json_decode($response->getBody())
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }  catch (RequestException $e) {
            if ($e->hasResponse()) {
                return json_encode([
                    'status' => 'error',
                    'message' => $e->getResponse()->getBody()->getContents()
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }


    public function initSession()
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        $body = [
            'app_token' => $this->appToken,
            'user_token'=> $this->userToken
        ];

        $result = $this->sendRequest('POST', '/initSession', $headers, $body);
        $this->sessionToken = json_decode($result)->data->session_token ?? null;

        return $result;
    }

    public function killSession()
    {
        $headers = [
            'app-token' => $this->appToken,
            'Session-Token' => $this->sessionToken->session_token,
        ];

        return $this->sendRequest('GET', '/killSession', $headers);
    }

    public function requestItem($item, $params = null)
    {
        $headers = [
            'Session-Token' => $this->sessionToken->session_token,
            'app-token' => $this->appToken,
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        return $this->sendRequest('GET', '/' . $item . '/' . ($params ?? ''), $headers);
    }


    public function addItem($item, $params = [])
    {
        $headers = [
            'Session-Token' => $this->sessionToken->session_token,
            'app-token' => $this->appToken,
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        return $this->sendRequest('POST', '/' . $item, $headers, $params);
    }

    public function updateItem($item, $id, $params)
    {
        $headers = [
            'Session-Token' => $this->sessionToken->session_token,
            'app-token' => $this->appToken,
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        return $this->sendRequest('PUT', '/' . $item . '/' . $id, $headers, $params);
    }

    public function deleteItem($item, $id)
    {
        $headers = [
            'Session-Token' => $this->sessionToken->session_token,
            'app-token' => $this->appToken,
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        return $this->sendRequest('DELETE', '/' . $item . '/' . $id, $headers);
    }

    public function purgeItem($item, $id)
    {
        $headers = [
            'Session-Token' => $this->sessionToken->session_token,
            'app-token' => $this->appToken,
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        return $this->sendRequest('DELETE', '/' . $item . '/' . $id . '?force_purge=true', $headers);
    }

    public function sendDocuments($item, $filename, $name)
    {
        if (!file_exists($filename)) {
            return json_encode([
                'status' => 'error',
                'message' => 'Arquivo não encontrado'
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        $headers = [
            'Session-Token' => $this->sessionToken->session_token,
            'app-token' => $this->appToken,
        ];

        $multipart = [
            [
                'name' => 'uploadManifest',
                'contents' => json_encode([
                    'input' => [
                        'name' => $name,
                        '_filename' => [$filename]
                    ]
                ])
            ],
            [
                'name' => 'filename',
                'contents' => Utils::tryFopen($filename, 'r'),
                'filename' => basename($filename),
            ],
        ];

        return $this->sendRequest('POST', '/' . $item, $headers, ['multipart' => $multipart]);
    }

    public static function render($result) {
        echo "<div style='background-color: #f0f0f0;
            border-radius: 10px;
            padding: 15px;
            margin: 20px;
            font-family: Arial, sans-serif;'> <pre>" . $result . "</pre></div>";
    }

    
}
