<?php

declare(strict_types=1);

namespace App\Domain\Usecases\HandleProduct;

final class OutputBoundary
{
    private int $id;
    private string $description;

    public function __construct(array $values)
    {
        $this->id = $values['id'];
        $this->type_id = $values['type_id'];
        $this->name = $values['name'];
        $this->description = $values['description'];
        $this->amount = $values['amount'];
    }

    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new RuntimeException(sprintf("Invalid Product Output Data Property '%s'", $name));
        }

        return $this->{$name};
    }
}
