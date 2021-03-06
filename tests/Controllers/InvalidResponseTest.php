<?php

namespace App\Tests\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class InvalidResponseTest extends WebTestCase {

    const URI = '/invalid_response';
    const METHOD = 'GET';

    public function testEmptyResponse() {
        $client = static::createClient();
        $client->request(self::METHOD, self::URI);
        $this->assertEquals(JsonResponse::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}