<?php

namespace App\Controller;

use App\Services\ApiHandler;
use App\Services\DeviceDetector;
use App\Services\UrlValidator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $res = $this->getShortlinkApiResponse($request, $url);
        $requestedUrl = $this->getUrlFromResponse($res);
        $urlValidator = new UrlValidator();

        if ($urlValidator->validate($requestedUrl)) {
            return $this->redirect($requestedUrl);
        }

        throw $this->createNotFoundException();
    }

    private function getShortlinkApiResponse(Request $request, $url) {
        $client = new Client();

        try {
            $res = $client->post($this->apiHandler->serveUrlRequest($url), $this->getStats($request));
        } catch (ClientException $ex) {
            throw $this->createNotFoundException();
        }

        return $res;
    }

    private function getUrlFromResponse(ResponseInterface $res) {
        $body = json_decode($res->getBody(), true);

        if (!isset($body['url'])) {
            throw $this->createNotFoundException();
        }

        return $body['url'];
    }

    private function getStats(Request $request) {
        $deviceDetector = new DeviceDetector($this->get('mobile_detect.mobile_detector'));

        return [
            'form_params' => [
                'ip' => $this->container->get('request_stack')->getCurrentRequest()->getClientIp(),
                'device' => $deviceDetector->getDevice(),
                'referer' => $request->headers->get('referer'),
            ]
        ];
    }
}