<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';
require_once './controllers/EmpleadoController.php';
require_once './db/DataAccess.php';

// Carga el archivo .env con la configuracion de la BD.
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
// Instantiate App
$app = AppFactory::create();
$app->setBasePath('/LaComanda');
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
$app->addBodyParsingMiddleware();


$app->group('/empleado', function (RouteCollectorProxy $group) {
  $group->post('[/]', \EmpleadoController::class . '::CargarUno');
  $group->put('/{id}', \EmpleadoController::class . '::ModificarUno');
  $group->delete('/{id}', \EmpleadoController::class . '::BorrarUno');
  $group->get('[/]', \EmpleadoController::class . '::TraerTodos');
  $group->get('/consulta', \EmpleadoController::class . '::TraerUno');

});


$app->run();
?>