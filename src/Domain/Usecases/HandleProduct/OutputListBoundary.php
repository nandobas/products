<?php

declare(strict_types=1);

namespace App\Domain\Usecases\HandleProduct;

final class OutputListBoundary
{
    private array $list;

    public function __construct(array $list)
    {
        $this->list = $list;
    }

    public function loadList():array
    {
        return $this->list;
    }
}
