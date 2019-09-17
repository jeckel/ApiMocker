<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 17/09/2019
 */

namespace App\Controller;

use App\Repository\ApiCallTraceRepository;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class TraceController
 * @package App\Controller
 */
class TraceController
{
    /**
     * @var ApiCallTraceRepository
     */
    protected $traceRepository;

    /**
     * TraceController constructor.
     * @param ApiCallTraceRepository $traceRepository
     */
    public function __construct(
        ApiCallTraceRepository $traceRepository
    ) {
        $this->traceRepository = $traceRepository;
    }

    /**
     * @param ResponseInterface      $response
     * @return ResponseInterface
     */
    public function getAll(
        ResponseInterface $response
    ): ResponseInterface {

        $response->getBody()->write(json_encode($this->traceRepository->getAll()));

        return $response->withStatus(StatusCodeInterface::STATUS_OK)
                ->withAddedHeader('Content-Type', 'application/json');
    }
}
