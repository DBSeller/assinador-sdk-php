<?php

namespace Dbseller\AssinadorSdkPhp;

class DBSellerSigner
{
    private array $config;

    /**
     * @throws \Exception
     */
    public function __construct(array $config)
    {
        if (empty($config["certificate"]) or !is_array($config["certificate"])) {
            throw new \Exception("Configuração inválida para api de certificados");
        }

        if (empty($config["signer"]) or !is_array($config["signer"])) {
            throw new \Exception("Configuração inválida para api de assinatura");
        }
        $this->config = $config;
    }

    public function certificate(): Certificate
    {
        return new Certificate(
            $this->config["certificate"]["url"],
            $this->config["certificate"]["user"],
            $this->config["certificate"]["password"]
        );
    }

    public function signer(): Signer
    {
        return new Signer(
            $this->config["signer"]["url"],
            $this->config["signer"]["user"],
            $this->config["signer"]["password"]
        );
    }
}