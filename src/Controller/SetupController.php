<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 16/09/2019
 */

namespace App\Controller;

use App\Entity\RouteMock;
use App\Mapper\RouteMockMapper;
use App\Repository\RouteMockRepository;
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
     * @param RouteMockMapper        $mapper
     * @param RouteMockRepository    $repo
     * @return ResponseInterface
     */
    public function addRouteMock(
        ServerRequestInterface $request,
        ResponseInterface $response,
        RouteMockMapper $mapper,
        RouteMockRepository $repo
    ): ResponseInterface {

        $route = $repo->save(
            $mapper->mapFromArray(
                new RouteMock(),
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
        $pdo->exec('DROP TABLE IF EXISTS route');

        // Create 'Route' Table
        $pdo->exec('CREATE TABLE IF NOT EXISTS route ( 
            id      INTEGER PRIMARY KEY AUTOINCREMENT,
            path    VARCHAR(255),
            method  VARCHAR(10),
            expectedBody TEXT,
            expectedHeaders TEXT,
            response TEXT,
            responseCode INTEGER
        );');

        $response->getBody()->write(json_encode(['Reset success'], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));
        return $response->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
