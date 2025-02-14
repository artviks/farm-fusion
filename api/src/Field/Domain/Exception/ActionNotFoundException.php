<?php

namespace App\Field\Domain\Exception;

use RuntimeException;

class ActionNotFoundException extends RuntimeException
{
    public static function forId(string $id): self
    {
        return new self("Action with ID {$id} was not found.");
    }
}