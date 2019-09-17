<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 26/07/2019
 */

use App\Controller\FakeApiController;
use App\Controller\SetupController;
use App\Middleware\FakeApiLoggerMiddleware;
use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Slim\Routing\RouteCollectorProxy;

if (! defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', dirname(__DIR__));
}

require_once '../vendor/autoload.php';

$container = (new ContainerBuilder())
    ->addDefinitions(PROJECT_ROOT . '/settings/container.php')
    ->build();

$app = Bridge::create($container);
$app->addBodyParsingMiddleware();

// Configuration API
$app->group('/fake-api-config', static function (RouteCollectorProxy $group) {
    $group->post('/routeMock', [SetupController::class, 'addRouteMock']);
    $group->delete('/reset', [SetupController::class, 'reset']);
});

$app->any('/[{route:.*}]', [FakeApiController::class, 'dispatch'])
    ->addMiddleware(
        $container->get(FakeApiLoggerMiddleware::class)
    );
$app->run();
