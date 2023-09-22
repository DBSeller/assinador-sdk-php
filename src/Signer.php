<?php

namespace Dbseller\AssinadorSdkPhp;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Signer implements Api
{

    private string $url = '';

    private string $user = '';

    private string $password = '';
    private ClientSigner $client;

    private string $filePath = '';

    private string $filePathPFX = '';

    private string $cpfCnpj = '';

    private string $qrcodeLink = '';

    private string $qrcodeHash = '';

    private string $logoBase64 = '';

    private string $header1 = '';


    public function __construct(?string $url = '', ?string $user = '', ?string $password = '')
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception("URL do assinador inválida!");
        }
        $this->setUrl($url);
        $this->setUser($user);
        $this->setPassword($password);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getClient(): ClientSigner
    {
        $this->client = new ClientSigner($this);
        return $this->client;
    }

    public function checkConnection(): ResponseInterface
    {
        return $this->getClient()->get("/signer/do");
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): self
    {
        $this->filePath = $filePath;
        return $this;
    }

    public function getFilePathPFX(): string
    {
        return $this->filePathPFX;
    }

    public function setFilePathPFX(string $filePathPFX): self
    {
        $this->filePathPFX = $filePathPFX;
        return $this;
    }

    public function getCpfCnpj(): string
    {
        return $this->cpfCnpj;
    }

    public function setCpfCnpj(string $cpfCnpj): self
    {
        $this->cpfCnpj = $cpfCnpj;
        return $this;
    }

    public function getQrcodeLink(): string
    {
        return $this->qrcodeLink;
    }

    public function setQrcodeLink(string $qrcodeLink): self
    {
        $this->qrcodeLink = $qrcodeLink;
        return $this;
    }

    public function getQrcodeHash(): string
    {
        return $this->qrcodeHash;
    }

    public function setQrcodeHash(string $qrcodeHash): self
    {
        $this->qrcodeHash = $qrcodeHash;
        return $this;
    }

    public function getLogoBase64(): string
    {
        return $this->logoBase64;
    }

    public function setLogoBase64(string $logoBase64): self
    {
        $this->logoBase64 = $logoBase64;
        return $this;
    }

    public function getHeader1(): string
    {
        return $this->header1;
    }

    public function setHeader1(string $header1): self
    {
        $this->header1 = $header1;
        return $this;
    }


    /**
     * @throws Exception
     */
    public function validateSigner()
    {
        if (!file_exists($this->getFilePath())) {
            throw new Exception("filepath inválido!");
        }

        if (!Validation::isPDF($this->getFilePath())) {
            throw new Exception("filepath ext inválido!");
        }

        if (!file_exists($this->getFilePathPFX())) {
            throw new Exception("filePathPFX inválido!");
        }

        if (!Validation::isPFX($this->getFilePathPFX())) {
            throw new Exception("filePathPFX  ext inválido!");
        }

        if (!Validation::cpfcnpj($this->getCpfCnpj())) {
            throw new Exception("CPF/CNPJ inválido!");
        }
    }

    /**
     * @throws Exception
     * @throws GuzzleException
     */
    public function signer()
    {

        $this->validateSigner();

        $params = [
            [
                'name' => 'pdf',
                'contents' => file_get_contents($this->getFilePath()),
                'filename' => basename($this->getFilePath())
            ],
            [
                'name' => 'pfx',
                'contents' => file_get_contents($this->getFilePathPFX()),
                'filename' => 'assinador.pfx'
            ],
            [
                'name' => 'userDocument',
                'contents' => $this->getCpfCnpj()
            ]
        ];

        if (!empty($this->getQrcodeLink())) {
            $params[] = [
                'name' => 'qrcodeLink',
                'contents' => $this->getQrcodeLink()
            ];
        }


        if (!empty($this->getQrcodeLink())) {
            $params[] = [
                'name' => 'qrcodeLink',
                'contents' => $this->getQrcodeLink()
            ];
        }

        if (!empty($this->getQrcodeHash())) {
            $params[] = [
                'name' => 'qrcodeHash',
                'contents' => $this->getQrcodeHash()
            ];
        }

        if (!empty($this->getLogoBase64())) {
            $params[] = [
                'name' => 'logoBase64',
                'contents' => $this->getLogoBase64()
            ];
        }

        if (!empty($this->getHeader1())) {
            $params[] = [
                'name' => 'header1',
                'contents' => $this->getHeader1()
            ];
        }

        $resp = $this->getClient()
            ->setTypeRequest($this->client::TYPE_REQUEST_MULTIPART)
            ->post(
                "/signer/do/make",
                $params
            );

        return $resp->getBody()->getContents();
    }
}