<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class WebApi
{
    protected HttpClientInterface $client;

    /**
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function get(string $url, array $options = []): ResponseInterface
    {
        return $this->sendRequest(Request::METHOD_GET, $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function post(string $url, array $options = []): ResponseInterface
    {
        return $this->sendRequest(Request::METHOD_POST, $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function patch(string $url, array $options = []): ResponseInterface
    {
        return $this->sendRequest(Request::METHOD_PATCH, $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function put(string $url, array $options = []): ResponseInterface
    {
        return $this->sendRequest(Request::METHOD_PUT, $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function delete(string $url, array $options = []): ResponseInterface
    {
        return $this->sendRequest(Request::METHOD_DELETE, $url, $options);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function sendRequest(string $method, string $url, array $options = []): ResponseInterface
    {
        return $this->getClient()->request($method, $url, $options);
    }

    /**
     * @todo: switch to HttpClientInterface (currently the DI did not work for some reason)
     * @return HttpClientInterface
     */
    protected function getClient(): HttpClientInterface
    {
        if(!isset($this->client)) {
            $this->client = HttpClient::create();
        }

        return $this->client;
    }
}
