<?php

declare(strict_types=1);

namespace App\Adapter\Controller;

use App\Domain\Repositories\ProductTypeRepository;
use App\Domain\Usecases\HandleProductType\HandleProductType;
use App\Domain\Usecases\HandleProductType\InputBoundary;
use Exception;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ProductType
{
    private ProductTypeRepository $productTypeRepository;

    public function __construct(ProductTypeRepository $productTypeRepository) 
    {
        $this->productTypeRepository = $productTypeRepository;
    }

    public function handleGetByID(Request $request, Response $response, array $args = []): Response
    {
        $useCase = new HandleProductType($this->productTypeRepository);       
        $inputData = new InputBoundary(
            (int)$args["id"]
        );

        $outputData = $useCase->loadById($inputData);

        $responsePayload = json_encode([
            'id' => $outputData->id,
            'description' => $outputData->description,
        ]);

        $response = $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(401);

        $response->getBody()->write($responsePayload);

        return $response;
    }
}