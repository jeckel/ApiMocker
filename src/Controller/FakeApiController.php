<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 17/09/2019
 */
namespace App\Controller;

use App\Entity\ApiCallTrace;
use App\Exception\ExceptionInterface;
use App\Repository\ApiCallTraceRepository;
use App\Repository\FakeRouteRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class FakeApiController
 * @package App\Controller
 */
class FakeApiController
{

    /**
     * @var FakeRouteRepository
     */
    protected $routeRepository;
    /**
     * @var ApiCallTraceRepository
     */
    protected $traceRepository;

    /**
     * FakeApiController constructor.
     * @param FakeRouteRepository    $routeRepository
     * @param ApiCallTraceRepository $traceRepository
     */
    public function __construct(
        FakeRouteRepository $routeRepository,
        ApiCallTraceRepository $traceRepository
    ) {
        $this->routeRepository = $routeRepository;
        $this->traceRepository = $traceRepository;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @return ResponseInterface
     */
    public function dispatch(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {

        try {
            $route = $this->routeRepository->getByRequest($request);
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

        /** @var ApiCallTrace $trace */
        $trace = $request->getAttribute('trace');
        $trace->setMatchedRouteId($route->getId());
        $this->traceRepository->save($trace);

        $response->getBody()->write($route->getResponse());
        $response = $response->withStatus($route->getResponseCode());
        foreach ($route->getResponseHeaders() as $header => $value) {
            $response = $response->withAddedHeader($header, $value);
        }
        return $response;
    }
}
