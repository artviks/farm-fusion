<?php

declare(strict_types=1);

namespace App\Field\Infrastructure\Presentation\Controller;

use App\Common\ApiResponse;
use App\Field\Application\UseCases\AddField\AddFieldService;
use App\Field\Infrastructure\Presentation\Request\AddFieldRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

readonly class AddFieldController
{
    public function __construct(
        private AddFieldService $addFieldService,
    ) {
    }

    #[Route('/fields' , name: 'add_field', methods: ['POST'], format: 'json')]
    public function __invoke(
        #[MapRequestPayload] AddFieldRequest $request
    ): JsonResponse {
        $command = $request->toCommand();
        $response = $this->addFieldService->execute($command);

        return ApiResponse::successful($response, Response::HTTP_CREATED);
    }
}
