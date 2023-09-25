<?php
use Dbseller\AssinadorSdkPhp\DBSellerSigner;
use Dbseller\AssinadorSdkPhp\Signer;
use Dbseller\AssinadorSdkPhp\Validation;

require_once "src/helpers.php";

$config = include "src/config.php";

it("VALIDATE CONFIG CERTIFICATE", function () use ($config) {
    $dbsellerSigner = new DBSellerSigner($config);
    $certificate = $dbsellerSigner->certificate();
    expect($certificate)->toBeInstanceOf(\Dbseller\AssinadorSdkPhp\Certificate::class);
});


it("VALIDATE GENERATE CERTIFICATE", function () use ($config) {

    $dbsellerSigner = new DBSellerSigner($config);

    $certificate = $dbsellerSigner->certificate()
        ->setCpfCnpj("73877288014")
        ->setName("Carlos Henrique")
        ->generate();

    expect($certificate)->toBeString();
});

it("VALIDATE DOWNLOAD CERTIFICATE", function () use ($config) {

    $dbsellerSigner = new DBSellerSigner($config);
    $certificate = $dbsellerSigner->certificate()
        ->setCpfCnpj("73877288014")
        ->setName("Carlos Henrique")
        ->generate();

    $download = $dbsellerSigner->certificate()->downloadPFX($certificate);

    expect($download)->toBeFile();
});

it("VALIDATE CONFIG SIGNER", function () use ($config) {
    $dbsellerSigner = new DBSellerSigner($config);
    $signer = $dbsellerSigner->signer();
    expect($signer)->toBeInstanceOf(Signer::class);
});

it("SIGNER FILE", function () use ($config) {
    $dbsellerSigner = new DBSellerSigner($config);
    $signer = $dbsellerSigner->signer()
        ->setFilePathPFX("tmp/CarlosHenrique-49950051029.pfx")
        ->setFilePath("tmp/doc-modelo.pdf")
        ->setCpfCnpj("73877288014")
        ->signer();
    expect(Validation::isValid64base($signer))->toBeTrue();
});
