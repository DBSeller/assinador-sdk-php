<?php

namespace Dbseller\AssinadorSdkPhp;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Certificate implements Api
{

    private string $url;
    private string $user;
    private string $password;

    private ClientSigner $client;

    private string $name = '';
    private string $cpf_cnpj = '';


    public function __construct(string $url, ?string $user = '', ?string $password = '')
    {
        $this->setUrl($url);
        $this->setUser($user);
        $this->setPassword($password);
        $this->setClient(new ClientSigner($this));
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCpfCnpj(): string
    {
        return $this->cpf_cnpj;
    }

    public function setCpfCnpj(string $cpf_cnpj): self
    {
        $this->cpf_cnpj = preg_replace('/[^0-9]/', '', $cpf_cnpj);
        return $this;
    }

    public function getClient(): ClientSigner
    {
        return $this->client;
    }

    public function setClient(ClientSigner $client): void
    {
        $this->client = $client;
    }


    /**
     * @return string
     * @throws Exception
     * name file
     * @throws GuzzleException
     */
    public function generate(): string
    {

        if (empty($this->getName())) {
            throw new Exception("Nome é obrigatório");
        }


        if (!Validation::cpfcnpj($this->getCpfCnpj())) {
            throw new Exception("CPF/Cnpj é obrigatório");
        }

        $cn = "{$this->getName()}:{$this->getCpfCnpj()}";

        $resp = $this->getClient()
            ->post("/generate", [
                "subject" => [
                    'CN' => $cn
                ]
            ]);

        $contents = json_decode($resp->getBody()->getContents());
        return basename($contents->downloadURL);
    }

    public function downloadPFX($name, $outputPath = "tmp"): string
    {
        $resp = $this->getClient()->get("/download/" . trim($name));
        $pathFile = $outputPath . "/" . $name . ".pfx";
        file_put_contents($pathFile, $resp->getBody()->getContents());
        return $pathFile;
    }

    public function checkConnection(): ResponseInterface
    {
        return $this->getClient()->get("/");
    }
}