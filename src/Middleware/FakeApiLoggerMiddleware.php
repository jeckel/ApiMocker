<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 17/09/2019
 */

namespace App\Middleware;

use App\Entity\ApiCallTrace;
use App\Repository\ApiCallTraceRepository;
use DateTimeImmutable;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class FakeApiLoggerMiddleware
 * @package App\Middleware
 */
class FakeApiLoggerMiddleware implements MiddlewareInterface
{
    /**
     * @var ApiCallTraceRepository
     */
    protected $repository;

    /**
     * FakeApiLoggerMiddleware constructor.
     * @param ApiCallTraceRepository $repository
     */
    public function __construct(ApiCallTraceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws Exception
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $trace = new ApiCallTrace();
        $trace->setPath($request->getUri()->getPath())
            ->setMethod($request->getMethod())
            ->setBody($request->getBody()->getContents())
            ->setReceivedAt(new DateTimeImmutable());

        return $handler->handle(
            $request->withAttribute('trace', $trace)
        );
    }
}
