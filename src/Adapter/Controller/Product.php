<?php

declare(strict_types=1);

namespace App\Adapter\Controller;

use App\Domain\Repositories\ProductRepository;
use App\Domain\Usecases\HandleProduct\HandleProduct;
use App\Domain\Usecases\HandleProduct\InputBoundary;
use Exception;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class Product
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository) 
    {
        $this->productRepository = $productRepository;
    }

    public function handleGetByID(Request $request, Response $response, array $args = []): Response
    {
        $useCase = new HandleProduct($this->productRepository);       
        $inputData = new InputBoundary(
            (int)$args["id"]
        );

        $outputData = $useCase->loadById($inputData);

        $responsePayload = json_encode([
            'id' => $outputData->id,
            'type_id' => $outputData->type_id,
            'name' => $outputData->name,
            'description' => $outputData->description,
            'amount' => $outputData->amount,
        ]);

        $response = $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(401);

        $response->getBody()->write($responsePayload);

        return $response;
    }

    public function handleGetList(Request $request, Response $response, array $args = []): Response
    {
        $useCase = new HandleProduct($this->productRepository);

        $outputData = $useCase->loadList();

        $responsePayload = json_encode(
            $outputData->loadList(),
        );

        $response = $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(401);

        $response->getBody()->write($responsePayload);

        return $response;
    }
}