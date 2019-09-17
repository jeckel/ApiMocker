<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 17/09/2019
 */

use App\Controller\FakeApiController;
use App\Controller\SetupController;
use App\Controller\TraceController;
use App\Middleware\FakeApiLoggerMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // Configuration API
    $app->group('/fake-api-config', function (RouteCollectorProxy $group) {
        $group->post('/routeMock', [SetupController::class, 'addRouteMock']);
        $group->delete('/reset', [SetupController::class, 'reset']);
        $group->get('/trace', [TraceController::class, 'getAll']);
    });

    $app->any('/[{route:.*}]', [FakeApiController::class, 'dispatch'])
        ->addMiddleware(
            $app->getContainer()->get(FakeApiLoggerMiddleware::class)
        );
};
