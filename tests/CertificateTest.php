<?php

use Dbseller\AssinadorSdkPhp\Certificate;

$certificate = new Certificate("http://localhost:8888");

it("CONNECTING TO THE SERVER", function () use ($certificate) {
    $resp = $certificate->checkConnection();
    $contents = $resp->getBody()->getContents();
    expect($contents)->toBe("online");
});

it("GENERATE PFX CERTIFICATE VALIDATE NAME", function () use ($certificate) {
    $resp = $certificate->generate();
})->throws(\Exception::class, "Nome é obrigatório");

it("GENERATE PFX CERTIFICATE VALIDATE CPF/CNPJ", function () use ($certificate) {
    $certificate->setName("Carlos Henrique");
    $resp = $certificate->generate();
})->throws(\Exception::class, "CPF/Cnpj é obrigatório");


it("GENERATE CERTIFICATE PFX", function () use ($certificate) {
    $resp = $certificate->setCpfCnpj("00307194027")
        ->generate();
    expect($resp)->toBeString();
});

it('DOWNLOAD CERTIFICATE PFX', function () use ($certificate) {
    $fileName = $certificate->generate();
    $resp = $certificate->downloadPFX($fileName);
    expect($resp)->toBeFile();
});