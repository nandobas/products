<?php

declare(strict_types=1);

namespace App\Domain\Entities;

final class Product
{
    private int $id;
    private int $type_id;
    private string $name;
    private string $description;
    private string $amount;

    private function __construct(array $values)
    {
        $this->id           = $values['id'] ?? null;
        $this->type_id      = $values['type_id'];
        $this->name         = $values['name'];
        $this->description  = $values['description'];
        $this->amount       = $values['amount'];
    }

    public static function create(array $values): Product
    {
        $regex = "/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i";

        if (preg_match($regex, $values['name'])) {
            throw new RuntimeException(sprintf("Invalid name '%s'", $values['name']));
        }
        if (preg_match($regex, $values['description'])) {
            throw new RuntimeException(sprintf("Invalid description '%s'", $values['description']));
        }

        return new Product($values);
    }

    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new RuntimeException(sprintf("Invalid Product Property '%s'", $name));
        }

        return $this->{$name};
    }
}
