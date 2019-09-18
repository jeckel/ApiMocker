<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 17/09/2019
 */
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, // Should be set to false in production
            'dsn' => 'sqlite:'. (getenv('SQLITE_ROOT') ?:  __DIR__  . '/../var/database/database.sqlite'),
        ],
    ]);
};
