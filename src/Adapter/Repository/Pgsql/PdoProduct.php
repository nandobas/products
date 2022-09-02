<?php

declare(strict_types=1);

namespace App\Adapter\Repository\Pgsql;

use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepository;

use Exception;
use Throwable;
use PDO;

final class PdoProduct implements ProductRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createProduct(Product $product): bool
    {
        $query = " 
        INSERT INTO product.products 
        (id, type_id, name, description, amount) VALUES 
        (:id, :type_id, :name, :description, :amount); ";
        $statement = $this->pdo->prepare(
            $query    
        );
        
        $statement->execute(
            [
                ':id'           => $product->id, 
                ':type_id'      => $product->type_id,
                ':name'         => $product->name,
                ':description'  => $product->description,
                ':amount'       => (float)$product->amount
            ]);
        $record = $statement->rowCount();

        if (!$record) {
            throw new Exception(sprintf("PdoProduct: Não foi possível inserir o Product com a ID '%s'", $product->id));
        }

        return true;
    }

    public function loadById(int $id): Product
    {
        $statement = $this->pdo->prepare(
            "
            SELECT 
                p.id, 
                p.type_id, 
                p.name, 
                p.description, 
                p.amount 
            FROM 
                product.products p
            WHERE p.id = :id;
            "
        );

        $statement->execute([':id' => (int)$id]);
        $record = $statement->fetch();

        if (!$record) {
            throw new Exception(sprintf("PdoProduct: Product com a ID '%s' não encontrado", $id));
        }

        $product = Product::create([
            'id'           => $record['id'], 
            'type_id'      => $record['type_id'],
            'name'         => $record['name'],
            'description'  => $record['description'],
            'amount'       => $record['amount']
        ]);

        return $product;
    }

    public function removeProduct(int $id): bool
    {
        $statement = $this->pdo->prepare(
            "
            DELETE 
            FROM 
                product.products
            WHERE id = :id;
            "
        );

        $statement->execute([':id' => (int)$id]);
        return true;
        $record = $statement->rowCount();

        if ($statement->rowCount() <= 0) {
            throw new Exception(sprintf("PdoProduct: Não foi possível remover Product com a ID '%s'", $id));
        }

        return true;
    }
}
