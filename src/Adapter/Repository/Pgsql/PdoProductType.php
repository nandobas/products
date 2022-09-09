<?php

declare(strict_types=1);

namespace App\Adapter\Repository\Pgsql;

use App\Domain\Entities\ProductType;
use App\Domain\Exceptions\ProductTypeNotFoundException;
use App\Domain\Repositories\ProductTypeRepository;

use Exception;
use Throwable;
use PDO;

final class PdoProductType implements ProductTypeRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createProductType(ProductType $productType): bool
    {
        $query = " INSERT INTO product.types (id, description) VALUES (:id, :description); ";
        $statement = $this->pdo->prepare(
            $query    
        );

        $statement->execute([':id' => $productType->id, ':description' => $productType->description]);
        $record = $statement->rowCount();

        if (!$record) {
            throw new Exception(sprintf("Não foi possível inserir o Product Type com a ID '%s'", $productType->id));
        }

        return true;
    }

    public function loadList(): array
    {
        $statement = $this->pdo->prepare(
            "
            SELECT 
                pt.id, 
                pt.description 
            FROM 
                product.types pt
            ORDER BY pt.id;
            "
        );

        $statement->execute();
        $records = $statement->fetchAll();
        
        if (!$records) {
            throw new Exception(sprintf("PdoProductType: não existem registros para Product Type", $id));
        }

        return $records;
    }

    public function loadById(int $id): ProductType
    {
        $statement = $this->pdo->prepare(
            "
            SELECT 
                pt.id, 
                pt.description 
            FROM 
                product.types pt
            WHERE pt.id = :id;
            "
        );

        $statement->execute([':id' => (int)$id]);
        $record = $statement->fetch();

        if (!$record) {
            throw new Exception(sprintf("PdoProductType: Product Type com a ID '%s' não encontrado", $id));
        }

        $type = ProductType::create(['id'=>$record['id'], 'description'=>$record['description']]);

        return $type;
    }

    public function removeProductType(int $id): bool
    {
        $statement = $this->pdo->prepare(
            "
            DELETE 
            FROM 
                product.types
            WHERE id = :id;
            "
        );

        $statement->execute([':id' => (int)$id]);

        if ($statement->rowCount() <= 0) {
            throw new Exception(sprintf("PdoProductType: Não foi possível remover o Product Type com a ID '%s'", $id));
        }

        return true;
    }
}
