<?php

namespace App\Services;

/**
 * Clase que facilita la composición de urls para las peticiones a la api.
 */
class ApiHandler
{
    private $apiUrl;
    private $apiPath;

    public function __construct($apiUrl, $apiPath) {
        $this->apiUrl = $apiUrl;
        $this->apiPath = $apiPath;
    }

    public function serveUrlRequest($url) {
        return $this->apiUrl.$this->apiPath.$url;
    }
}