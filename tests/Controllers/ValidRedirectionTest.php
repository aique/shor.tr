<?php

namespace App\Tests\Controllers;

use App\Controller\MockController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class ValidRedirectionTest extends WebTestCase {

    const URI = '/valid_redirection';
    const METHOD = 'GET';

    public function testEmptyResponse() {
        $client = static::createClient();
        $client->request(self::METHOD, self::URI);
        $this->assertEquals(JsonResponse::HTTP_FOUND, $client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(MockController::VALID_REDIRECTION_URL, $client->getHistory()->current()->getUri());
    }
}