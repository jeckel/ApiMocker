<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 26/07/2019
 */

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;

use App\Router;

require_once '../vendor/autoload.php';

$config = include getenv('CONFIG_FILE');

$router = new Router();

$app = AppFactory::create();

// Configuration API
$app->get('fake-api-config', static function(RequestInterface $request, ResponseInterface $response, array $args) {
    $payload = json_encode(['hello' => 'world'], JSON_PRETTY_PRINT);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

// Matching routes
$app->any('/[{route:.*}]', static function(RequestInterface $request, ResponseInterface $response) use ($config, $router) {
    return $router->init($config)->dispatch($request, $response);
});

$app->run();
