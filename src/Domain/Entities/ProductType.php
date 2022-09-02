<?php

declare(strict_types=1);

namespace App\Domain\Entities;

final class ProductType
{
    private int $id;
    private string $description;

    private function __construct(array $values)
    {
        $this->id = $values['id'] ?? null;
        $this->description = $values['description'];
    }

    public static function create(array $values): ProductType
    {
        $regex = "/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i";

        if (preg_match($regex, $values['description'])) {
            throw new RuntimeException(sprintf("Invalid description '%s'", $values['description']));
        }

        return new ProductType($values);
    }

    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new RuntimeException(sprintf("Invalid Product Type Property '%s'", $name));
        }

        return $this->{$name};
    }
}
