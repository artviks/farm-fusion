<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;

readonly class FieldSummary
{
    public function __construct(
        public int $id,
        public string $name,
        public string $crop,
        public string $cropSeason,
        public string $size,
        public string $sowingDate,
        public string $expectedHarvestDate,
        public string $growthStage,
        public string $lastTreatment,
        public string $nextTreatment,
        public string $alerts,
    ) {
    }
}