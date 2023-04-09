<?php

namespace App\Helpers;

class CpfCnpjValidator
{
    public static function validateCPF($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        $digitos = str_split($cpf);

        if (count(array_unique($digitos)) === 1) {
            return false;
        }

        for ($i = 9; $i < 11; $i++) {
            $soma = 0;

            for ($j = 0; $j < $i; $j++) {
                $soma += ($i - $j) * $digitos[$j];
            }

            $digito = (($soma % 11) < 2) ? 0 : (11 - ($soma % 11));

            if ($digitos[$i] != $digito) {
                return false;
            }
        }

        return true;
    }

    public static function validateCNPJ($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        if (strlen($cnpj) != 14) {
            return false;
        }

        $digitos = str_split($cnpj);

        if (count(array_unique($digitos)) === 1) {
            return false;
        }

        $multiplicadores1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $soma1 = 0;

        for ($i = 0; $i < 12; $i++) {
            $soma1 += $multiplicadores1[$i] * $digitos[$i];
        }

        $digito1 = (($soma1 % 11) < 2) ? 0 : (11 - ($soma1 % 11));

        if ($digitos[12] != $digito1) {
            return false;
        }

        $multiplicadores2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $soma2 = 0;

        for ($i = 0; $i < 13; $i++) {
            $soma2 += $multiplicadores2[$i] * $digitos[$i];
        }

        $digito2 = (($soma2 % 11) < 2) ? 0 : (11 - ($soma2 % 11));

        if ($digitos[13] != $digito2) {
            return false;
        }

        return true;
    }
}
