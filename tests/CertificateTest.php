<?php

use Dbseller\AssinadorSdkPhp\Certificate;

require_once "src/helpers.php";
$config = include "src/config.php";

function createCertificate(array $config): Certificate
{
    return new Certificate(
        $config["certificate"]["url"],
        $config["certificate"]["user"],
        $config["certificate"]["password"]
    );
}

function skipWhenCertificateConfigMissing(array $config, $testCase): void
{
    if (empty($config["certificate"]["url"])) {
        $testCase->markTestSkipped("Configure SIGNER_CERTIFICATE_URL para testes de integracao.");
    }
}

it("CONNECTING TO THE SERVER", function () use ($config) {
    skipWhenCertificateConfigMissing($config, $this);
    $certificate = createCertificate($config);
    $resp = $certificate->checkConnection();
    $contents = $resp->getBody()->getContents();
    expect($contents)->toBe("online");
});

it("GENERATE PFX CERTIFICATE VALIDATE NAME", function () use ($config) {
    skipWhenCertificateConfigMissing($config, $this);
    $certificate = createCertificate($config);
    $resp = $certificate->generate();
})->throws(\Exception::class, "Nome é obrigatório");

it("GENERATE PFX CERTIFICATE VALIDATE CPF/CNPJ", function () use ($config) {
    skipWhenCertificateConfigMissing($config, $this);
    $certificate = createCertificate($config);
    $certificate->setName("Carlos Henrique");
    $resp = $certificate->generate();
})->throws(\Exception::class, "CPF/Cnpj é obrigatório");


it("NORMALIZE CERTIFICATE NAME", function () use ($config) {
    $certificate = createCertificate($config);
    $certificate->setName("  C@rlo's H&nr|qu# D! /liv\$ir\"a Souza  ");
    $name = $certificate->getName();
    expect(strpos($name, '/'))->toBeFalse();
    expect((bool) preg_match('/^[A-Za-z0-9\s]+$/', $name))->toBeTrue();
});


it("GENERATE CERTIFICATE PFX", function () use ($config) {
    skipWhenCertificateConfigMissing($config, $this);
    $certificate = createCertificate($config);
    $resp = $certificate->setCpfCnpj("49950051029")
        ->generate();
    expect($resp)->toBeString();
});

it('DOWNLOAD CERTIFICATE PFX', function () use ($config) {
    skipWhenCertificateConfigMissing($config, $this);
    $certificate = createCertificate($config);
    $fileName = $certificate->generate();
    $resp = $certificate->downloadPFX($fileName);
    expect($resp)->toBeFile();
});
