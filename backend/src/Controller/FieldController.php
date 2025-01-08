<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\CreateFieldRequest;
use App\Service\FieldService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/field')]
class FieldController extends AbstractController
{
    public function __construct(
        private readonly FieldService $fieldService
    ) {
    }

    #[Route('/', name: 'fields', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $fields = $this->fieldService->getFields();

        return new JsonResponse($fields);
    }

    #[Route('/field/{id}', name: 'field', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $field = $this->fieldService->getField($id);

        return new JsonResponse($field);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/field', name: 'create_field', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $payload = $request->getPayload()->all();
        $createFieldRequest = CreateFieldRequest::fromPayload($payload);
        $this->fieldService->createField($createFieldRequest);

        return new JsonResponse(Response::HTTP_CREATED);
    }
}
