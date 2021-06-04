<?php


namespace App\Utils\Validation;


use App\Exceptions\InvalidCnpjException;
use Http\StatusHttp;

class Cnpj
{
    public function __construct(
        private string $cnpj
    )
    {
        if (!$this->validate()) {
            throw new InvalidCnpjException(message: "CNPJ Inválido", statusCode: StatusHttp::EXPECTATION_FAILED);
        }
    }

    public function __toString()
    {
        return $this->cnpj;
    }

    public function validate()
    {
        $cnpj = preg_replace('/[^0-9]/is', '', $this->cnpj);

        if (strlen($cnpj) != 14) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cnpj)) {
            return false;
        }

        // Validate first check digit
        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $result = $sum % 11;


        if ($cnpj[12] != ($result < 2 ? 0 : 11 - $result)) {
            return false;
        }

        // Validate second check digit
        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $result = $sum % 11;


        return $cnpj[13] == ($result < 2 ? 0 : 11 - $result);
    }

}
