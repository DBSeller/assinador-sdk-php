<?php

namespace Dbseller\AssinadorSdkPhp;

class Validation
{

    const INVALID_CPF = [
        '00000000000',
        '11111111111',
        '22222222222',
        '33333333333',
        '44444444444',
        '55555555555',
        '66666666666',
        '77777777777',
        '88888888888',
        '99999999999',
    ];

    const INVALID_CNPJ = [
        '00000000000000',
        '11111111111111',
        '22222222222222',
        '33333333333333',
        '44444444444444',
        '55555555555555',
        '66666666666666',
        '77777777777777',
        '88888888888888',
        '99999999999999',
    ];

    public static function cpf($cpf)
    {

        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (in_array($cpf, self::INVALID_CPF)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {

            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    public static function cnpj($cnpj)
    {
        $cnpj = preg_replace("/[^0-9]/", "", $cnpj);
        if (strlen($cnpj) != 14) {
            return false;
        }


        if (in_array($cnpj, self::INVALID_CNPJ)) {
            return false;
        }

        $j = 5;
        $k = 6;
        $soma1 = 0;
        $soma2 = 0;

        for ($i = 0; $i < 13; $i++) {

            $j = $j == 1 ? 9 : $j;
            $k = $k == 1 ? 9 : $k;
            $soma2 += ($cnpj[$i] * $k);

            if ($i < 12) {
                $soma1 += ($cnpj[$i] * $j);
            }

            $k--;
            $j--;

        }

        $digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
        $digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;

        return (($cnpj[12] == $digito1) and ($cnpj[13] == $digito2));
    }


    public static function cpfcnpj($cpfCnpj)
    {
        $cpfCnpj = preg_replace('/[^0-9]/', '', $cpfCnpj);

        if (strlen($cpfCnpj) == 11) {
            return self::cpf($cpfCnpj);
        }

        if (strlen($cpfCnpj) == 14) {
            return self::cnpj($cpfCnpj);
        }
    }

    public static function isPDF($pathfile)
    {
        $ext = pathinfo($pathfile, PATHINFO_EXTENSION);
        if (strtolower($ext) == "pdf") {
            return true;
        }
        return false;
    }

    public static function isPFX($pathfile)
    {
        $ext = pathinfo($pathfile, PATHINFO_EXTENSION);
        if (strtolower($ext) == "pfx") {
            return true;
        }
        return false;
    }

    public static function isValid64base($str): bool
    {
        return base64_decode($str, true) !== false;
    }
}