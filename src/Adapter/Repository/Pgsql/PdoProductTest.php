<?php
declare(strict_types=1);

namespace Tests\Repository;
error_reporting(E_ALL ^ E_DEPRECATED);
use App\Config\AppConfig;
use App\Infra\Database\PdoConnection;
use App\Adapter\Repository\Pgsql\PdoProductType;
use App\Domain\Entities\ProductType;
use App\Adapter\Repository\Pgsql\PdoProduct;
use App\Domain\Entities\Product;
use PHPUnit\Framework\TestCase as PHPUnitTestCast;
use PDO;

final class TestPdoProduct extends PHPUnitTestCast
{
    private PDO $pdo;
    
    public function __construct($name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);
         
        $appConfig = new AppConfig();
        $pdoConnection = new PdoConnection($appConfig);
        $this->pdo = $pdoConnection->getTx();
    }

    public function testIfCreateProductReturnsTheCorrectCountInsert()
    {
        //Arrange
        $productType = ProductType::create([
            'id' => 60,
            'description' => 'frutas',
        ]);
        $makePdoProductType = new PdoProductType($this->pdo);
        $makePdoProductType->createProductType($productType);

        $product = Product::create([
            'id'           => 100, 
            'type_id'      => 60,
            'name'         => 'Mamao Papaia',
            'description'  => 'Fruta mamao importada',
            'amount'       => '15.33'
        ]);
        $makePdoProduct = new PdoProduct($this->pdo);

        //Act
        $result = $makePdoProduct->createProduct($product);

        //Assert
        $this->assertSame($result, true);

        //Act
        $result = $makePdoProduct->removeProduct(100);
        $this->assertTrue($result);
        $result = $makePdoProductType->removeProductType(60);
        $this->assertTrue($result);
    }
}
