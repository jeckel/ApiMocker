<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 16/09/2019
 */

namespace App\Repository;

use App\Entity\RouteMock;
use PDO;

/**
 * Class RouteMockRepository
 * @package App\Repository
 */
class RouteMockRepository
{
    /** @var PDO */
    protected $pdo;

    /**
     * RouteMockRepository constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param RouteMock $route
     * @return RouteMock
     */
    public function save(RouteMock $route): RouteMock
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO route 
            (path, method, expectedBody, expectedHeaders, response, responseCode) 
            VALUES (:path, :method, :expectedBody, :expectedHeaders, :response, :responseCode)'
        );

        $stmt->execute([
            ':path' => $route->getPath(),
            ':method' => $route->getMethod(),
            ':expectedBody' => json_encode($route->getExpectedBody(), JSON_THROW_ON_ERROR),
            ':expectedHeaders' => json_encode($route->getExpectedHeaders(), JSON_THROW_ON_ERROR),
            ':response' => json_encode($route->getResponse(), JSON_THROW_ON_ERROR),
            ':responseCode' => $route->getResponseCode()
        ]);

        $route->setId(intval($this->pdo->lastInsertId()));
        return $route;
    }
}
