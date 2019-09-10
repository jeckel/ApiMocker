<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 10/09/2019
 */

namespace App;

use App\Entity\RouteConfig;
use Psr\Container\ContainerInterface;

/**
 * Class RouteConfigRepositoryFactory
 * @package App
 */
class RouteConfigRepositoryFactory
{
    /**
     * @param ContainerInterface $container
     * @return RouteConfigRepository
     */
    public function __invoke(ContainerInterface $container): RouteConfigRepository
    {
        /** @var array $config */
        $config = $container->get('config');

        $repo = new RouteConfigRepository();

        foreach ($config as $routeConfigArray) {
            $routeConfig = new RouteConfig($routeConfigArray);
            $repo->addRouteConfig($routeConfig);
        }

        return $repo;
    }
}
