<?php

namespace App\Services\Api;

/**
 * Clase que facilita la composición de urls para las peticiones a la api.
 */
class ApiHandler
{
    private $apiUrl;

    public function __construct($apiUrl) {
        $this->apiUrl = $apiUrl;
    }

    public function serveUrlRequest($url) {
        return $this->apiUrl.'/api/shortlink/'.$url;
    }
}