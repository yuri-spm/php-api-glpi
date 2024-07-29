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

    public function initSession()
    {
        $client = new Client();

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $body = json_encode([
            'app_token' => $this->appToken,
            'user_token'=> $this->userToken
        ]);

        $uri = $this->apiUrl . '/initSession';

        try {
            $request = new Request('POST', $uri, $headers, $body);
            $response = $client->sendAsync($request)->wait();
            $this->sessionToken = json_decode($response->getBody());
            return json_encode([
                'status' => 'success',
                'message' => 'Conectado com sucesso',
                'session_token' => $this->sessionToken->session_token
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                return json_encode([
                    'status' => 'error',
                    'message' => $response->getBody()->getContents()
                ]);
            }
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

        try {
            $response = $client->request('GET', $url, ['headers' => $headers]);
            return json_encode([
                'status' => 'success',
                'message' => 'Sessão finalizada'
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                return json_encode([
                    'status' => 'error',
                    'message' => $response->getBody()->getContents()
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        }
    }

    public function requestItem($item, $params = null)
    {
        $client = new Client();

        $url = $this->apiUrl . '/' . $item . '/' . ($params ?? '');

        $headers = [
            'Session-Token' => $this->sessionToken->session_token,
            'app-token' => $this->appToken,
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        try {
            $response = $client->request('GET', $url, ['headers' => $headers]);
            return json_encode([
                'status' => 'success',
                'data' => json_decode($response->getBody())
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                return json_encode([
                    'status' => 'error',
                    'message' => $response->getBody()->getContents()
                ]);
            }
        }
    }

    // Os métodos restantes seguem o mesmo padrão...

    public function addItem($item, $params = [])
    {
        $client = new Client();

        $url = $this->apiUrl . '/' . $item;

        $headers = [
            'Session-Token' => $this->sessionToken->session_token,
            'app-token' => $this->appToken,
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        $body = json_encode($params);

        try {
            $response = $client->request('POST', $url, ['headers' => $headers, 'body' => $body]);
            return json_encode([
                'status' => 'success',
                'data' => json_decode($response->getBody())
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                return json_encode([
                    'status' => 'error',
                    'message' => $response->getBody()->getContents()
                ]);
            }
        }
    }

    public function updateItem($item, $id, $params)
    {
        $client = new Client();

        $url = $this->apiUrl . '/' . $item . '/' . $id;

        $headers = [
            'Session-Token' => $this->sessionToken->session_token,
            'app-token' => $this->appToken,
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        $body = json_encode($params);

        try {
            $response = $client->request('PUT', $url, ['headers' => $headers, 'body' => $body]);
            return json_encode([
                'status' => 'success',
                'data' => json_decode($response->getBody())
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                return json_encode([
                    'status' => 'error',
                    'message' => $response->getBody()->getContents()
                ]);
            }
        }
    }

    public function deleteItem($item, $id)
    {
        $client = new Client();

        $url = $this->apiUrl . '/' . $item . '/' . $id;

        $headers = [
            'Session-Token' => $this->sessionToken->session_token,
            'app-token' => $this->appToken,
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        try {
            $response = $client->request('DELETE', $url, ['headers' => $headers]);
            return json_encode([
                'status' => 'success',
                'data' => json_decode($response->getBody())
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                return json_encode([
                    'status' => 'error',
                    'message' => $response->getBody()->getContents()
                ]);
            }
        }
    }

    public function purgeItem($item, $id)
    {
        $client = new Client();

        $url = $this->apiUrl . '/' . $item . '/' . $id . '?force_purge=true';

        $headers = [
            'Session-Token' => $this->sessionToken->session_token,
            'app-token' => $this->appToken,
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu'
        ];

        try {
            $response = $client->request('DELETE', $url, ['headers' => $headers]);
            return json_encode([
                'status' => 'success',
                'data' => json_decode($response->getBody())
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                return json_encode([
                    'status' => 'error',
                    'message' => $response->getBody()->getContents()
                ]);
            }
        }
    }

    public function sendDocuments($item, $filename)
    {
        $client = new Client();

        $url = $this->apiUrl . '/' . $item;

        if (!file_exists($filename)) {
            return json_encode([
                'status' => 'error',
                'message' => 'Arquivo não encontrado'
            ]);
        }

        $headers = [
            'Authorization' => 'Basic Z2xwaTouQURNX1MzcnYxYzMu',
            'Session-Token' => $this->sessionToken->session_token,
            'app-token' => $this->appToken,
        ];

        $body = [
            'multipart' => [
                [
                    'name' => 'uploadManifest',
                    'contents' => json_encode([
                        'input' => [
                            'name' => $filename,
                            '_filename' => [$filename]
                        ]
                    ])
                ],
                [
                    'name' => 'filename',
                    'contents' => Utils::tryFopen($filename, 'r'),
                    'filename' => basename($filename),
                ],
            ],
        ];

        try {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'multipart' => $body['multipart'],
            ]);

            return json_encode([
                'status' => 'success',
                'data' => json_decode($response->getBody())
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                return json_encode([
                    'status' => 'error',
                    'message' => $response->getBody()->getContents()
                ]);
            }
        }
    }
}
