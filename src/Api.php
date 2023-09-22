<?php

namespace Dbseller\AssinadorSdkPhp;

interface Api
{
    public function getUrl(): string;

    public function getUser(): string;

    public function getPassword(): string;

    public function checkConnection();

}