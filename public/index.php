<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 26/07/2019
 */

use App\Router;

require_once '../vendor/autoload.php';

$config_dir = getenv('CONFIG_DIR');
$config = include $config_dir . '/config.php';

$router = new Router();
$router->init($config)->dispatch();
