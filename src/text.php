<?php

class GLPIApi
{
    private $apiUrl;
    private $username;
    private $password;
    private $appToken;

    public function __construct($apiUrl, $username, $password, $appToken)
    {
        $this->apiUrl = $apiUrl;
        $this->username = $username;
        $this->password = $password;
        $this->appToken = $appToken;
    }

    public function makeApiRequest($endpoint, $method = 'GET', $data = [])
    {
        $url = $this->apiUrl . $endpoint;

        // Adiciona o app_token aos dados se não estiver presente
        if (!isset($data['app_token'])) {
            $data['app_token'] = $this->appToken;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "{$this->username}:{$this->password}");

        // Configura o método da requisição
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } elseif ($method != 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpCode == 200) {
            return json_decode($response, true);
        } else {
            throw new Exception("Erro na requisição: $httpCode. Resposta: $response");
        }
    }

    public function getTicket($ticketId)
    {
        $endpoint = "tickets/$ticketId";
        return $this->makeApiRequest($endpoint);
    }
}
?>
