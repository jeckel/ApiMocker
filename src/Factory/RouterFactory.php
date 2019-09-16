<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 16/09/2019
 */

namespace App\Factory;

use App\Service\Router;
use Psr\Container\ContainerInterface;

/**
 * Class RouterFactory
 * @package App\Factory
 */
class RouterFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @return Router
     */
    public function __invoke(ContainerInterface $container)
    {
        return (new Router())->init($container->get('config')['routes']);
    }
}
