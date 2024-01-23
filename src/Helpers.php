<?php

function api($apiUrl, $username, $password, $appToken){
    return (new GLPIApi($apiUrl, $username, $password, $appToken));
}

function api_createCurlSession($url, $headers){

    $curl = curl_init(); 
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => $headers,
      ));

    return $curl;
}

function api_executeCurlSession($curl) {
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}


