<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;

#[ApiResource]
#[Get]
class FieldsSummary
{
    /**
     * @var FieldSummary[]
     */
    private array $fields;

    public function __construct(FieldSummary ...$fields)
    {
        $this->fields = $fields;
    }
}