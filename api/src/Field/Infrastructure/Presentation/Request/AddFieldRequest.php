<?php

namespace App\Field\Infrastructure\Presentation\Request;


use App\Common\Converter;
use App\Field\Application\UseCases\AddField\AddFieldCommand;
use Symfony\Component\Validator\Constraints as Assert;

readonly class AddFieldRequest
{
    public function __construct(
        #[
            Assert\NotBlank,
            Assert\Type('string'),
        ]
        private string $name,

        #[
            Assert\NotBlank,
            Assert\Type('numeric'),
            Assert\Positive,
        ]
        private float $size,

        #[Assert\Type('string')]
        private ?string $notes,
    ) {}

    public function toCommand(): AddFieldCommand
    {
        return AddFieldCommand::new($this->name, Converter::floatToInt($this->size), $this->notes);
    }
}