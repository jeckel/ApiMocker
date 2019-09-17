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
use Psr\Log\LoggerInterface;

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
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * FakeApiLoggerMiddleware constructor.
     * @param ApiCallTraceRepository $repository
     * @param LoggerInterface        $logger
     */
    public function __construct(ApiCallTraceRepository $repository, LoggerInterface $logger)
    {
        $this->repository = $repository;
        $this->logger = $logger;
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
