<?php

namespace App\Tests\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class UnknownUrlTest extends WebTestCase {

    const URI = '/unknown_url';
    const METHOD = 'GET';

    public function testUnknownUrl() {
        $client = static::createClient();
        $client->request(self::METHOD, self::URI);
        $this->assertEquals(JsonResponse::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}