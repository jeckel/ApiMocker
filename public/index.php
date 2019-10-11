<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 26/07/2019
 */

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

if (! defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', dirname(__DIR__));
}

require_once '../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();
if (false) { // Should be set to true in production
    $containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

// Set up settings
$settings = require __DIR__ . '/../config/settings.php';
$settings($containerBuilder);

$dependencies = require __DIR__ . '/../config/dependencies.php';
$dependencies($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();


// Instantiate the app
AppFactory::setContainer($container);
//$app = AppFactory::create();
$app = Bridge::create($container);

// Register middleware
$middleware = require __DIR__ . '/../config/middleware.php';
$middleware($app);
// Register routes
$routes = require __DIR__ . '/../config/routes.php';
$routes($app);

$app->run();
