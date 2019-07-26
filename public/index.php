<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 26/07/2019
 */

use App\Router;

require_once '../vendor/autoload.php';

$config = include getenv('CONFIG_FILE');

$router = new Router();
$router->init($config)->dispatch();
