<?php

namespace App\Controller;

use App\Services\Api\ApiHandler;
use App\Services\DeviceDetection\DeviceDetectorHelper;
use App\Services\Validation\UrlValidator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    public function serveUrl(Request $request, $url) {
        $client = new Client();

        try {
            $res = $client->post($this->apiHandler->serveUrlRequest($url), $this->getStats($request));
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

    private function getStats(Request $request) {
        $deviceDetector = new DeviceDetectorHelper($this->get('mobile_detect.mobile_detector'));

        return [
            'form_params' => [
                'ip' => $this->container->get('request_stack')->getCurrentRequest()->getClientIp(),
                'device' => $deviceDetector->getDevice(),
                'referer' => $request->headers->get('referer'),
            ]
        ];
    }
}