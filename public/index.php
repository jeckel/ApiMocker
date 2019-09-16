<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 26/07/2019
 */

use App\Factory\RouterFactory;
use DI\Bridge\Slim\Bridge;
use DI\Container;
use DI\ContainerBuilder;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use App\Service\Router;
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

// Configuration API
$app->get('fake-api-config', static function(RequestInterface $request, ResponseInterface $response, array $args) {
    $payload = json_encode(['hello' => 'world'], JSON_PRETTY_PRINT);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

// Matching routes
$app->any('/[{route:.*}]', static function(RequestInterface $request, ResponseInterface $response, Router $router) {
    return $router->dispatch($request, $response);
});

$app->run();
