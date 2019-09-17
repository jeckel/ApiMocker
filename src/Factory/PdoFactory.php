<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 16/09/2019
 */

namespace App\Factory;

use Exception;
use PDO;
use Psr\Container\ContainerInterface;
use RuntimeException;

/**
 * Class PdoFactory
 * @package App\Factory
 */
class PdoFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @return PDO
     */
    public function __invoke(ContainerInterface $container)
    {
        try {
            $pdo = new PDO($container->get('settings')['dsn']);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // Possible values ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            throw new RuntimeException('Impossible to access SQLite database: '.$e->getMessage());
        }
        return $pdo;
    }
}
