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

        if ($body) {
            $options['body'] = json_encode($body);
        }

        try {
            $response = $client->request($method, $url, $options);
            $responseBody = json_decode($response->getBody());

            return $responseBody;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody()->getContents());
            }
            return json_decode($e->getMessage());
        }
    }


    public function initSession()
    {
        $client = new Client();

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $body = json_encode([
            'app_token' => $this->appToken,
            'user_token' => $this->userToken
        ]);

        $uri = $this->apiUrl . '/initSession';

        try {
            $request = new Request('POST', $uri, $headers, $body);
            $response = $client->send($request); // `send` é síncrono e mais confiável aqui
            $responseBody = json_decode($response->getBody()->getContents(), true);

            if (isset($responseBody['session_token']) && !empty($responseBody['session_token'])) {
                $this->sessionToken = $responseBody['session_token'];

                return json_encode([
                    'status' => 'success',
                    'session_token' => $this->sessionToken,
                    'message' => 'Conectado com sucesso',
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            } else {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Falha ao obter session_token',
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                return json_encode([
                    'status' => 'error',
                    'message' => $response->getBody()->getContents()
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            } else {
                return json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        }
    }



    public function killSession()
    {
        $headers = [
            'app-token' => $this->appToken,
            'Session-Token' => $this->sessionToken,
        ];

        return $this->sendRequest('GET', '/killSession', $headers);
    }

    public function requestItem($item, $params = null)
    {
        $headers = [
            'Session-Token' => $this->sessionToken,
            'app-token' => $this->appToken,
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        return $this->sendRequest('GET', '/' . $item . '/' . ($params ?? ''), $headers);
    }


    public function addItem($item, $params = [])
    {
        $headers = [
            'Session-Token' => $this->sessionToken,
            'app-token' => $this->appToken,
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];
        
        return $this->sendRequest('POST', '/' . $item, $headers, $params);
    }

    public function updateItem($item, $id, $params)
    {
        $headers = [
            'Session-Token' => $this->sessionToken,
            'app-token' => $this->appToken,
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        return $this->sendRequest('PUT', '/' . $item . '/' . $id, $headers, $params);
    }

    public function deleteItem($item, $id)
    {
        $headers = [
            'Session-Token' => $this->sessionToken,
            'app-token' => $this->appToken,
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        return $this->sendRequest('DELETE', '/' . $item . '/' . $id, $headers);
    }

    public function purgeItem($item, $id)
    {
        $headers = [
            'Session-Token' => $this->sessionToken,
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
            'Session-Token' => $this->sessionToken,
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

    public static function render($result)
    {
        echo "<div style='background-color: #f0f0f0;
            border-radius: 10px;
            padding: 15px;
            margin: 20px;
            font-family: Arial, sans-serif;'> <pre>" . $result . "</pre></div>";
    }
}
