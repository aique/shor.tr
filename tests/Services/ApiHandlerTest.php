<?php

namespace App\Tests\Services;

use App\Services\Api\ApiHandler;
use PHPUnit\Framework\TestCase;

class ApiHandlerTest extends TestCase {

    const API_HANDLER_URL = "http://admin.shor.tr/";
    const API_HANDLER_PATH = "api/shortlink";
    const SHORT_TEST_URL = "qwerty";

    /** @var ApiHandler */
    private $apiHandler;

    public function setUp() {
        $this->apiHandler = new ApiHandler(self::API_HANDLER_URL, self::API_HANDLER_PATH);
    }

    public function testServeRequest() {
        $urlRequest = self::API_HANDLER_URL.self::API_HANDLER_PATH.self::SHORT_TEST_URL;

        $this->assertEquals($urlRequest, $this->apiHandler->serveUrlRequest(self::SHORT_TEST_URL));
    }
}