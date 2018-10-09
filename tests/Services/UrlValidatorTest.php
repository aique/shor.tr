<?php

namespace App\Tests;

use App\Services\UrlValidator;
use PHPUnit\Framework\TestCase;

class UrlValidatorTest extends TestCase {

    private $validUrls;
    private $invalidUrls;

    /** @var UrlValidator */
    private $urlValidator;

    public function setUp() {
        $this->urlValidator = new UrlValidator();

        $this->validUrls = [
            'http://test.com',
            'http://test.com/something',
            'http://test.com/something:8080',
        ];

        $this->invalidUrls = [
            'test',
            'test.com',
            'http://',
            'test://test.com',
            'http:test.com',
        ];
    }

    public function testValidator() {
        $this->assertValidUrls();
        $this->assertInvalidUrls();
    }

    private function assertValidUrls() {
        foreach ($this->validUrls as $url) {
            $this->assertTrue($this->urlValidator->validate($url));
        }
    }

    private function assertInvalidUrls() {
        foreach ($this->invalidUrls as $url) {
            $this->assertFalse($this->urlValidator->validate($url));
        }
    }
}