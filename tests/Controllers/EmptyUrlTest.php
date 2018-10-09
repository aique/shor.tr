<?php

namespace App\Tests\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class EmptyUrlTest extends WebTestCase {

    public function testEmptyUrl() {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(JsonResponse::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}