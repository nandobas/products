<?php
use App\Config\AppConfig;
use App\Infra\Database\PdoConnection;
use App\Adapter\Controller\ProductType;
use App\Adapter\Controller\MockTypeController;
use App\Adapter\Repository\Pgsql\PdoProductType;
use App\Infra\Http\PlugRoutePsrAdapter;
use PlugRoute\PlugRoute;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Nyholm\Psr7\Factory\Psr17Factory;

error_reporting(E_ALL ^ E_DEPRECATED);

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/vendor/autoload.php';

final class App
{
    private PlugRoute $route;
    
    public function __construct(PlugRoute $route, ProductType $productTypeController) {
        $this->route = $route;
        $this->productTypeController = $productTypeController;

        $this->route
        ->get('/type/{id}')
        ->callback(function(\PlugRoute\Http\Request $request, \PlugRoute\Http\Response $response) {
            
            $requestPsr = PlugRoutePsrAdapter::adaptRequest($request);
            $responsePsr = PlugRoutePsrAdapter::adaptResponse($response);

            $productTypeResponse = $this->productTypeController->handleGetByID($requestPsr, $responsePsr, $request->parameters());
            $responseAsArray = json_decode($productTypeResponse->getBody(), true);

            $response->setStatusCode($productTypeResponse->getStatusCode())
                ->addHeaders($productTypeResponse->getHeaders());

            echo $response->json($responseAsArray);
        });
    }

    public function Start(){
        $this->route->run();
    }
}     
$appConfig = new AppConfig();
$pdoConnection = new PdoConnection($appConfig);
$pdo = $pdoConnection->getTx();

$route = new \PlugRoute\PlugRoute();

$productTypeRepository = new PdoProductType($pdo);
$productTypeController = new ProductType($productTypeRepository);

$app = new App($route, $productTypeController);
$app->Start();
