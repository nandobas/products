<?php

declare(strict_types=1);

namespace App\Domain\Entities;

final class ChargeFee
{
    private int $id;
    private int $type_id;
    private string $charge_fee;
    private string $in_place_since;

    private function __construct(array $values)
    {
        $this->id               = $values['id'] ?? null;
        $this->type_id          = $values['type_id'];
        $this->name             = $values['charge_fee'];
        $this->in_place_since   = $values['in_place_since'];
    }

    public static function create(array $values): Product
    {
        return new ChargeFee($values);
    }

    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new RuntimeException(sprintf("Invalid ChargeFee Property '%s'", $name));
        }

        return $this->{$name};
    }
}
