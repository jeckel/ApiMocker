<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 17/09/2019
 */

namespace App\Controller;

use App\Exception\ExceptionInterface;
use App\Repository\RouteMockRepository;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class FakeApiController
 * @package App\Controller
 */
class FakeApiController
{
    public function dispatch(
        ServerRequestInterface $request,
        ResponseInterface $response,
        RouteMockRepository $repository
    ): ResponseInterface {


        try {
            $route = $repository->getByRequest($request);
        } catch (ExceptionInterface $e) {
            $response->getBody()->write(json_encode(
                [
                    'error_code' => 500,
                    'error_message' => $e->getMessage()
                ],
                JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR
            ));
            return $response->withStatus(500, $e->getMessage());
        }

        // Log call
        // Add response headers

        $response->getBody()->write($route->getResponse());
        return $response->withStatus($route->getResponseCode());
    }
}
