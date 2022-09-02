<?php

declare(strict_types=1);

namespace App\Adapter\Controller;

use App\Domain\Repositories\ProductTypeRepository;

final class MockTypeController
{
    private ProductTypeRepository $typeRepository;

    public function __construct(ProductTypeRepository $typeRepository) 
    {
        $this->typeRepository = $typeRepository;
    }
    public function test(){
        var_dump($this->typeRepository->loadById(1));
    }
}
