<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 16/09/2019
 */

namespace App\Repository;

use App\Entity\FakeRoute;
use App\Exception\RoutingException;
use App\Mapper\FakeRouteMapper;
use PDO;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class RouteMockRepository
 * @package App\Repository
 */
class FakeRouteRepository
{
    /** @var PDO */
    protected $pdo;
    /**
     * @var FakeRouteMapper
     */
    protected $mapper;

    /**
     * RouteMockRepository constructor.
     * @param PDO             $pdo
     * @param FakeRouteMapper $mapper
     */
    public function __construct(PDO $pdo, FakeRouteMapper $mapper)
    {
        $this->pdo = $pdo;
        $this->mapper = $mapper;
    }

    /**
     * @param FakeRoute $route
     * @return FakeRoute
     */
    public function save(FakeRoute $route): FakeRoute
    {
        if ($route->getId() === null) {
            return $this->insert($route);
        }
        return $this->update($route);
    }

    /**
     * @param FakeRoute $route
     * @return FakeRoute
     */
    public function insert(FakeRoute $route): FakeRoute
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO route 
            (path, method, expectedBody, expectedHeaders, response, responseCode, responseHeaders) 
            VALUES (:path, :method, :expectedBody, :expectedHeaders, :response, :responseCode, :responseHeaders)'
        );

        $stmt->execute([
            ':path' => $route->getPath(),
            ':method' => $route->getMethod(),
            ':expectedBody' => json_encode($route->getExpectedBody(), JSON_THROW_ON_ERROR),
            ':expectedHeaders' => json_encode($route->getExpectedHeaders(), JSON_THROW_ON_ERROR),
            ':response' => json_encode($route->getResponse(), JSON_THROW_ON_ERROR),
            ':responseCode' => $route->getResponseCode(),
            ':responseHeaders' => json_encode($route->getResponseHeaders(), JSON_THROW_ON_ERROR)
        ]);

        $route->setId(intval($this->pdo->lastInsertId()));
        return $route;
    }

    /**
     * @param FakeRoute $route
     * @return FakeRoute
     */
    public function update(FakeRoute $route): FakeRoute
    {
        $stmt = $this->pdo->prepare('UPDATE route SET
                path = :path,
                method = :method,
                expectedBody = :expectedBody,
                expectedHeaders = :expectedHeaders,
                response = :response,
                responseCode = :responseCode,
                responseHeaders = :responseHeaders
            WHERE id = :id');

        $stmt->execute([
            ':id' => $route->getId(),
            ':path' => $route->getPath(),
            ':method' => $route->getMethod(),
            ':expectedBody' => json_encode($route->getExpectedBody(), JSON_THROW_ON_ERROR),
            ':expectedHeaders' => json_encode($route->getExpectedHeaders(), JSON_THROW_ON_ERROR),
            ':response' => json_encode($route->getResponse(), JSON_THROW_ON_ERROR),
            ':responseCode' => $route->getResponseCode(),
            ':responseHeaders' => json_encode($route->getResponseHeaders(), JSON_THROW_ON_ERROR)
        ]);

        return $route;
    }

    /**
     * @param ServerRequestInterface $request
     * @return FakeRoute
     */
    public function getByRequest(ServerRequestInterface $request): FakeRoute
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        $stmt = $this->pdo->prepare('SELECT * FROM route WHERE path = :path AND method = :method');
        $stmt->execute([
            ':path' => $path,
            ':method' => $method
        ]);

        $results = $stmt->fetchAll();
        $matches = count($results);

        if ($matches === 0) {
            throw new RoutingException(sprintf(
                'No matching route found for %s with method %s',
                $path,
                $method
            ));
        }

        if ($matches > 1) {
            throw new RoutingException(sprintf(
                'Multiple route definition found for %s with method %s',
                $path,
                $method
            ));
        }

        return $this->mapper->mapFromRow(new FakeRoute(), $results[0]);
    }
}
