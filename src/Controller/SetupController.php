<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 16/09/2019
 */

namespace App\Controller;

use App\Entity\FakeRoute;
use App\Mapper\FakeRouteMapper;
use App\Repository\FakeRouteRepository;
use Fig\Http\Message\StatusCodeInterface;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class SetupController
 * @package App\Controller
 */
class SetupController
{
    /**
     * Add new expected route
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param FakeRouteMapper        $mapper
     * @param FakeRouteRepository    $repo
     * @return ResponseInterface
     */
    public function addRouteMock(
        ServerRequestInterface $request,
        ResponseInterface $response,
        FakeRouteMapper $mapper,
        FakeRouteRepository $repo
    ): ResponseInterface {

        $route = $repo->save(
            $mapper->mapFromArray(
                new FakeRoute(),
                $request->getParsedBody()
            )
        );

        $response->getBody()->write(json_encode($route, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
        return $response->withStatus(StatusCodeInterface::STATUS_OK);
    }

    /**
     * Reset|Initialize database configuration
     *
     * @param ResponseInterface      $response
     * @param PDO                    $pdo
     * @return ResponseInterface
     */
    public function reset(
        ResponseInterface $response,
        PDO $pdo
    ): ResponseInterface {
        // Create 'Route' table
        $pdo->exec('DROP TABLE IF EXISTS route');
        $pdo->exec('CREATE TABLE IF NOT EXISTS route ( 
            id      INTEGER PRIMARY KEY AUTOINCREMENT,
            path    VARCHAR(255),
            method  VARCHAR(10),
            expectedBody TEXT,
            expectedHeaders TEXT,
            response TEXT,
            responseCode INTEGER
        );');

        // Create 'api_call_trace' table
        $pdo->exec('DROP TABLE IF EXISTS api_call_trace');
        $pdo->exec('CREATE TABLE IF NOT EXISTS api_call_trace (
            id          INTEGER PRIMARY KEY AUTOINCREMENT,
            route_id    INTEGER NULL,
            path        VARCHAR(255),
            method      VARCHAR(10),
            body        TEXT,
            received_at DATETIME                                          
        )');

        $response->getBody()->write(json_encode(['Reset success'], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));
        return $response->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
