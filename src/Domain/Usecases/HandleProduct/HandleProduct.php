<?php

namespace App\Domain\Usecases\HandleProduct;

use App\Domain\Repositories\ProductRepository;

final class HandleProduct
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository) 
    {
        $this->repository = $repository;
    }

    public function loadList(): OutputListBoundary
    {
        $registrations = $this->repository->loadList();
        return new OutputListBoundary([
            'list'=>$registrations
        ]);  
    }

    public function loadById(InputBoundary $input): OutputBoundary
    {
        $registration = $this->repository->loadById($input->getId());
        return new OutputBoundary([
            'id'=>$registration->id,
            'type_id'=>$registration->type_id,
            'name'=>$registration->name,
            'description'=>$registration->description,
            'amount'=>$registration->amount
        ]);  
    }
}
