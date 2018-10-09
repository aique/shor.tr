<?php

namespace App\Services;

class UrlValidator
{
    public function validate($url) {
        if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)) {
            return true;
        }

        return false;
    }
}