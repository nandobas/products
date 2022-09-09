<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\Product;

interface ProductRepository
{
    public function createProduct(Product $product): bool;
    public function loadList(): array;
    public function loadById(int $id): Product;
    public function removeProduct(int $id): bool;
}
