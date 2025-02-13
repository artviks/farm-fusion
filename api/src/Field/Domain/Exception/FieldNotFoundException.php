<?php

namespace App\Field\Domain\Exception;

use RuntimeException;

class FieldNotFoundException extends RuntimeException
{
    public static function forId(string $id): self
    {
        return new self("Field with ID {$id} was not found.");
    }
}