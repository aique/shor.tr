<?php

namespace App\Services\Validation;

class UrlValidator
{
    private $url;

    public function __construct($url) {
        $this->url = $url;
    }

    public function validate() {
        return preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $this->url);
    }
}