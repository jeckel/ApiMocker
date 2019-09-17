<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 26/07/2019
 */

use App\Controller\SetupController;
use App\Factory\RouterFactory;
use DI\Bridge\Slim\Bridge;
use DI\Container;
use DI\ContainerBuilder;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use App\Service\Router;
use Slim\App;
use function DI\factory;

if (! defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', dirname(__DIR__));
}

require_once '../vendor/autoload.php';

$app = Bridge::create(
    (new ContainerBuilder())
        ->addDefinitions(PROJECT_ROOT . '/settings/container.php')
        ->build()
    );
$app->addBodyParsingMiddleware();

// Configuration API
$app->group('/fake-api-config', static function ($app) {
    $app->post('/routeMock', [SetupController::class, 'addRouteMock']);
    $app->delete('/reset', [SetupController::class, 'reset']);
});

// Matching routes
$app->any('/[{route:.*}]', static function(RequestInterface $request, ResponseInterface $response, Router $router) {
    return $router->dispatch($request, $response);
});

$app->run();
