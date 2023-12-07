# assinador-sdk-php
Sdk para para  utilizar funcionalidades da api de assinatura digital e de certificado digital 

# required
- php >= 7.4
- ext-iconv
- ext-json

# INSTALAÇÃO
```terminal
  composer require dbseller/assinador-sdk-php
```
# Laravel
Para publicar o arquivo de configuração utilize o seguinte comando
```terminal
php artisan vendor:publish --tag="dbseller-signer-config"
```
Registre o provider no arquivo config/app.php conforme o exemplo
```PHP
'providers' => [
     \Dbseller\AssinadorSdkPhp\DBSellerSignerServiceProvider::class
]

```

Configuração arquivo .env

```file
  SIGNER_CERTIFICATE_URL=Host do servidor da aplicação de certificado
  SIGNER_CERTIFICATE_USER=Usuário para autenticação basica caso exista
  SIGNER_CERTIFICATE_PASSWORD=Senha para autenticação basica caso exista

  SIGNER_URL=Host do servidor da aplicação do assinador
  SIGNER_USER=Usuário para autenticação basica caso exista
  SIGNER_PASSWORD=Senha para autenticação basica caso exist
```

Utilização do SDK para gerar um certificado PFX


```PHP
public function assinar(\Dbseller\AssinadorSdkPhp\DBSellerSigner $DBSellerSigner)
{
       
      /**
      *Bloco para gerar o certificado na api de certificado
      **/
        $fileName = $DBSellerSigner->certificate()
            ->setCpfCnpj("000.000.000-00")
            ->setName("NOME DO CIDADÃO")
            ->generate();

       /**
      *Bloco para baixar o certificado na api de certificado e armazenar no local desejado na maquina
      **/
        $path_file = storage_path("app/certificates");
        $pfxFile = $DBSellerSigner->certificate()->downloadPFX($fileName, $path_file);

       /**
       *Bloco para assinadr o cdocumento
      **/
         $fileSigner = $DBSellerSigner->signer()
                    ->setCpfCnpj("000.000.000-00")
                    ->setFilePath("diretorio do arquivo a ser assinado")
                    ->setFilePathPFX($pfxFile)
                    ->signer();

}
```

