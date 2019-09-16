<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 16/09/2019
 */

use App\Factory\PdoFactory;
use App\Factory\RouterFactory;
use App\Service\Router;
use function DI\factory;

if (! defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', dirname(__DIR__));
}

return [
    'config' => [
        'dsn' => 'sqlite:'. (getenv('SQLITE_ROOT') || PROJECT_ROOT . '/data/database/database.sqlite'),
        'routes' => include getenv('CONFIG_FILE'),
    ],
    Router::class => factory(RouterFactory::class),
    PDO::class => factory(PdoFactory::class)
];
