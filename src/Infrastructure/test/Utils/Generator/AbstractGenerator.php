<?php

namespace InfrastructureTest\Utils\Generator;

class AbstractGenerator implements GenerateInterface
{
    /**
     * Return rest of equation. Specific for generate CPF
     */
    public function mod(int $dividend, int $divider): int
    {
        $floor  = floor($dividend / $divider);
        $calc   = $dividend - ($floor * $divider);

        return (int)round($calc);
    }

    public function randomNumber(): int
    {
        $calc = (mt_rand() / mt_getrandmax()) * 9;

        return (int)round($calc);
    }
}
