<?php

namespace Dbseller\AssinadorSdkPhp;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class ClientSigner
{

    const TYPE_REQUEST_JSON = "json";
    const TYPE_REQUEST_MULTIPART = "multipart";
    const TYPE_REQUEST_FORM_PARAMS = "form_params";

    const TYPE_REQUEST_OPTIONS = [
        self::TYPE_REQUEST_FORM_PARAMS,
        self::TYPE_REQUEST_JSON,
        self::TYPE_REQUEST_MULTIPART
    ];

    private $client;

    private Api $api;

    private string $typeRequest = "json";

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function setApi(Api $api): void
    {
        $this->api = $api;
    }

    public function getApi(): Api
    {
        return $this->api;
    }

    public function getTypeRequest(): string
    {
        return $this->typeRequest;
    }

    /**
     * @throws \Exception
     */
    public function setTypeRequest(string $typeRequest): self
    {
        if (!in_array($typeRequest, self::TYPE_REQUEST_OPTIONS)) {
            throw new \Exception("Tipo de request inválido!");
        }
        $this->typeRequest = $typeRequest;

        return $this;
    }


    public function __construct(Api $api)
    {
        $this->setApi($api);
        $this->setClient(new Client([
            'verify' => false,
            'base_uri' => $this->getApi()->getUrl(),
        ]));
    }

    /**
     * @throws GuzzleException
     */
    public function post($url, array $params = []): ResponseInterface
    {
        $options = [
            $this->getTypeRequest() => $params,
            'auth' => self::makeAuth()
        ];
        return $this->getClient()->post($url, $options);
    }

    public function get($url, array $params = [])
    {
        return $this->getClient()->get($url, [
            $this->getTypeRequest() => $params,
            'auth' => self::makeAuth()
        ]);
    }

    private function makeAuth(): array
    {
        return [
            $this->getApi()->getUser(),
            $this->getApi()->getPassword(),
            'Basic'
        ];
    }
}