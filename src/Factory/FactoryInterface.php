<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 16/09/2019
 */

namespace App\Factory;

use Psr\Container\ContainerInterface;

/**
 * Interface FactoryInterface
 * @package App\Factory
 */
interface FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @return mixed
     */
    public function __invoke(ContainerInterface $container);
}
