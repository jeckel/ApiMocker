<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 17/09/2019
 */

use Slim\App;

return function (App $app) {
    $app->addBodyParsingMiddleware();
};
