<?php

namespace App\Common;

class Converter
{
    private const int MULTIPLIER = 100;

    public static function floatToInt(float $value): ?int
    {
        return (int) round($value * self::MULTIPLIER);
    }
}