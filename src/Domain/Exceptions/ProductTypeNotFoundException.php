<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use Exception;
use Throwable;

class ProductTypeNotFoundException extends Exception
{
    public function __construct(int $id, $code = 0, Throwable $previous = null)
    {
        $message = "Product Type com a ID '{$id}' não encontrado";
        parent::__construct($message, $code, $previous);
    }
}
