<?php

namespace App\Domain\Usecases\HandleProductType;

use App\Domain\Repositories\ProductTypeRepository;

final class HandleProductType
{
    private ProductTypeRepository $repository;

    public function __construct(ProductTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function loadList(): OutputListBoundary
    {
        $registrations = $this->repository->loadList();
        return new OutputListBoundary([
            'list' => $registrations
        ]);
    }

    public function loadById(InputBoundary $input): OutputBoundary
    {
        $registration = $this->repository->loadById($input->getId());
        return new OutputBoundary([
            'id' => $registration->id,
            'description' => $registration->description
        ]);
    }
}
