<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CpfValidator implements Rule
{
    public function passes($attribute, $value)
    {
        // Remover caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $value);

        // Verificar se o CPF tem 11 caracteres
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verificar se o CPF é composto por números iguais (ex: 111.111.111.11)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Validação do primeiro dígito verificador
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += $cpf[$i] * (10 - $i);
        }
        $firstVerifier = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);
        if ($cpf[9] != $firstVerifier) {
            return false;
        }

        // Validação do segundo dígito verificador
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += $cpf[$i] * (11 - $i);
        }
        $secondVerifier = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);
        if ($cpf[10] != $secondVerifier) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'O CPF fornecido não é válido.';
    }
}
