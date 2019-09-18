<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 17/09/2019
 */

use App\Factory\PdoFactory;
use DI\ContainerBuilder;
use function DI\factory;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        PDO::class => factory(PdoFactory::class)
    ]);
};
