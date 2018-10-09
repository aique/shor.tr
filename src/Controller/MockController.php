<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mock")
 */
class MockController extends Controller {

    const VALID_REDIRECTION_URL = 'http://www.youtube.com';

    /**
     * @Route("/unknown_url", name="unknown_url")
     */
    public function badRequestResponse() {
        return new JsonResponse([], JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/empty_response", name="empty_response")
     */
    public function emptyUrlResponse() {
        return new JsonResponse([], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/invalid_response", name="invalid_response")
     */
    public function invalidUrlResponse() {
        return new JsonResponse(['url' => 'invalid.url'], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/valid_redirection", name="valid_redirection")
     */
    public function validRedirectionResponse() {
        return new JsonResponse(['url' => self::VALID_REDIRECTION_URL], JsonResponse::HTTP_OK);
    }
}