<?php

namespace App\Controller;

use App\Services\Api\ApiHandler;
use App\Services\Validation\UrlValidator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    private $apiHandler;

    public function __construct(ApiHandler $apiHandler) {
        $this->apiHandler = $apiHandler;
    }

    /**
     * @Route("/", name="index")
     */
    public function index() {
        throw $this->createNotFoundException();
    }

    /**
     * @Route("/{url}", name="serve_url")
     */
    public function serveUrl($url) {
        $client = new Client();

        try {
            $res = $client->request('GET', $this->apiHandler->serveUrlRequest($url));
        } catch (ClientException $ex) {
            throw $this->createNotFoundException();
        }

        $body = json_decode($res->getBody(), true);

        if (!isset($body['url'])) {
            throw $this->createNotFoundException();
        }

        $requestedUrl = $body['url'];
        $urlValidator = new UrlValidator($requestedUrl);

        if ($urlValidator->validate()) {
            return $this->redirect($requestedUrl);
        }

        throw $this->createNotFoundException();
    }
}