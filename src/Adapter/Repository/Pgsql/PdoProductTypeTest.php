<?php

declare(strict_types=1);

namespace Tests\Repository;

error_reporting(E_ALL ^ E_DEPRECATED);
use App\Config\AppConfig;
use App\Infra\Database\PdoConnection;
use App\Adapter\Repository\Pgsql\PdoProductType;
use App\Domain\Entities\ProductType;
use App\Domain\Exceptions\ProductTypeNotFoundException;
use App\Domain\Repositories\ProductTypeRepository;
use PHPUnit\Framework\TestCase as PHPUnitTestCast;
use PDO;

final class TestPdoProductType extends PHPUnitTestCast
{
    private PDO $pdo;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $appConfig = new AppConfig();
        $pdoConnection = new PdoConnection($appConfig);
        $this->pdo = $pdoConnection->getTx();
    }

    public static function makePdoProductType(): PdoProductType
    {
        return new PdoProductType($this->pdo);
    }

    public function testIfCreateReturnsTheCorrectCountInsert()
    {
        //Arrange
        $productType = ProductType::create([
            'id' => 50,
            'description' => 'frutas',
        ]);
        $makePdoProductType = new PdoProductType($this->pdo);

        //Act
        $result = $makePdoProductType->createProductType($productType);

        //Assert
        $this->assertSame($result, true);

        //Act
        $result = $makePdoProductType->removeProductType(50);

        //Assert
        $this->assertTrue($result);
    }
}
