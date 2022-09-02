<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\ProductType;

interface ProductTypeRepository
{
    public function createProductType(ProductType $productType): bool;
    public function loadById(int $id): ProductType;
    public function removeProductType(int $id): bool;
}
