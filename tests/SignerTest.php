<?php

use Dbseller\AssinadorSdkPhp\Signer;
use Dbseller\AssinadorSdkPhp\Validation;

require_once "src/helpers.php";
$config = include "src/config.php";

function createSigner(array $config): Signer
{
    return new Signer(
        $config["signer"]["url"],
        $config["signer"]["user"],
        $config["signer"]["password"]
    );
}

function skipWhenSignerConfigMissing(array $config, $testCase): void
{
    if (empty($config["signer"]["url"])) {
        $testCase->markTestSkipped("Configure SIGNER_URL para testes de integracao.");
    }
}

it("CONNECTING TO THE SERVER", function () use ($config) {
    skipWhenSignerConfigMissing($config, $this);
    $signer = createSigner($config);
    $response = $signer->checkConnection();
    expect($response->getBody()->getContents())->toBe("ASSINADOR E-CIDADE");
});

it("VALIDATE PATH FILE", function () use ($config) {
    skipWhenSignerConfigMissing($config, $this);
    $signer = createSigner($config);
    $signer->signer();
})->throws(Exception::class, "filepath inválido!");

it("VALIDATE FILE IS PDF", function () use ($config) {
    skipWhenSignerConfigMissing($config, $this);
    $signer = createSigner($config);
    $signer->setFilePath("tmp/CarlosHenrique-49950051029.pfx");
    $signer->signer();
})->throws(Exception::class, "filepath ext inválido!");

it("VALIDATE PATH PFX", function () use ($config) {
    skipWhenSignerConfigMissing($config, $this);
    $signer = createSigner($config);
    $signer->setFilePath("tmp/doc-modelo.pdf")
        ->signer();
})->throws(Exception::class, "filePathPFX inválido!");

it("VALIDATE FILE IS PFX", function () use ($config) {
    skipWhenSignerConfigMissing($config, $this);
    $signer = createSigner($config);
    $signer->setFilePath("tmp/doc-modelo.pdf")
        ->setFilePathPFX("tmp/doc-modelo.pdf")
        ->signer();
})->throws(Exception::class, "filePathPFX  ext inválido!");

it("VALIDATE CPF/CNPJ", function () use ($config) {
    skipWhenSignerConfigMissing($config, $this);
    $signer = createSigner($config);
    $signer->setFilePath("tmp/doc-modelo.pdf")
        ->setFilePathPFX("tmp/CarlosHenrique-49950051029.pfx")
        ->setCpfCnpj("12312")
        ->signer();
})->throws(Exception::class, "CPF/CNPJ inválido!");

it("SIGNER PDF", function () use ($config) {
    skipWhenSignerConfigMissing($config, $this);
    $signer = createSigner($config);
    $resp = $signer->setFilePath("tmp/doc-modelo.pdf")
        ->setFilePathPFX("tmp/CarlosHenrique-49950051029.pfx")
        ->setCpfCnpj("49950051029")
        ->signer();
    expect(Validation::isValid64base($resp))->toBeTrue();
});
