<?php

declare(strict_types=1);

namespace App\Domain\Usecases\HandleProductType;

final class OutputBoundary
{
    private int $id;
    private string $description;

    public function __construct(array $values)
    {
        $this->id = $values['id'];
        $this->description = $values['description'];
    }

    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new RuntimeException(sprintf("Invalid Product Type Output Data Property '%s'", $name));
        }

        return $this->{$name};
    }
}
