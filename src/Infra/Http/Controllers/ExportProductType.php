<?php

declare(strict_types=1);

namespace App\Infra\Http\Controllers;

use App\Application\Usecases\HandleProductType\HandleProductType;
use App\Application\Usecases\HandleProductType\InputBoundary;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ExportProductType
{
    private Request $request;
    private Response $response;
    private HandleProductType $useCase;

    public function __construct(
        Request $request,
        Response $response,
        HandleProductType $useCase
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->useCase = $useCase;
    }

    public function getById(Presentation $presentation): Response
    {
        $inputBoundary = new InputBoundary(
            1
        );

        $output = $this->useCase->getById($inputBoundary);

        $this->response
            ->getBody()
            ->write($presentation->output([
                'data' => [
                    'id' => $output->id,
                    'description' => $output->description,
                ]
            ]));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
