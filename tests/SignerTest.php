<?php

use Dbseller\AssinadorSdkPhp\Signer;
use Dbseller\AssinadorSdkPhp\Validation;

require_once "src/helpers.php";
$config = include "src/config.php";

$signer = new Signer(
    $config["signer"]["url"],
    $config["signer"]["user"],
    $config["signer"]["password"]
);

it("CONNECTING TO THE SERVER", function () use ($signer) {
    $response = $signer->checkConnection();
    expect($response->getBody()->getContents())->toBe("ASSINADOR E-CIDADE");
});

it("VALIDATE PATH FILE", function () use ($signer) {
    $signer->signer();
})->throws(Exception::class, "filepath inválido!");

it("VALIDATE FILE IS PDF", function () use ($signer) {
    $signer->setFilePath("tmp/CarlosHenrique-49950051029.pfx");
    $signer->signer();
})->throws(Exception::class, "filepath ext inválido!");

it("VALIDATE PATH PFX", function () use ($signer) {
    $signer->setFilePath("tmp/doc-modelo.pdf")
        ->signer();
})->throws(Exception::class, "filePathPFX inválido!");

it("VALIDATE FILE IS PFX", function () use ($signer) {
    $signer->setFilePath("tmp/doc-modelo.pdf")
        ->setFilePathPFX("tmp/doc-modelo.pdf")
        ->signer();
})->throws(Exception::class, "filePathPFX  ext inválido!");

it("VALIDATE CPF/CNPJ", function () use ($signer) {
    $signer->setFilePath("tmp/doc-modelo.pdf")
        ->setFilePathPFX("tmp/CarlosHenrique-49950051029.pfx")
        ->setCpfCnpj("12312")
        ->signer();
})->throws(Exception::class, "CPF/CNPJ inválido!");

it("SIGNER PDF", function () use ($signer) {
    $resp = $signer->setFilePath("tmp/doc-modelo.pdf")
        ->setFilePathPFX("tmp/CarlosHenrique-49950051029.pfx")
        ->setCpfCnpj("49950051029")
        ->signer();
    expect(Validation::isValid64base($resp))->toBeTrue();
});

