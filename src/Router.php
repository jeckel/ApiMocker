<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 26/07/2019
 */

namespace App;

use App\Exception\ExceptionInterface;
use App\Exception\RoutingException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Router
 */
class Router
{
    protected $config;

    protected $routes = [];

    protected $logs = [];

    protected $logFile;

    /**
     * @param array $config
     * @return Router
     */
    public function init(array $config): self
    {
        $this->logFile = getenv('LOG_FILE');
        $this->config = $config;
        $this->initializeRoutes($config);
        return $this;
    }

    /**
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function dispatch(
        RequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();
        try {
            $route = $this->findMatchingRoute($method, $path);
        } catch (ExceptionInterface $e) {
            $response->getBody()->write(json_encode(
                [
                    'error_code' => 500,
                    'error_message' => $e->getMessage()
                ],
                JSON_PRETTY_PRINT
            ));
            return $response->withStatus(500, $e->getMessage());
        }
        $this->logCall($route);
        $response->getBody()->write($route->getResponse());
        return $response->withStatus($route->getResponseCode());
    }

    /**
     * @param array $config
     */
    protected function initializeRoutes(array $config): void
    {
        foreach ($config as $routeConfig) {
            $this->routes[] = new Route($routeConfig);
        }
    }

    /**
     * @param string $method
     * @param string $path
     * @return Route
     */
    protected function findMatchingRoute(string $method, string $path): Route
    {
        $matches = array_filter($this->routes, static function (Route $route) use ($method, $path) {
            return ($route->getMethod() === $method) &&
                ($route->getUri() === $path);
        });
        if (count($matches) === 0) {
            throw new RoutingException(sprintf(
                'No matching route found for %s with method %s',
                $path,
                $method
            ));
        }

        if (count($matches) > 1) {
            throw new RoutingException(sprintf(
                'Multiple route definition found for %s with method %s',
                $path,
                $method
            ));
        }

        return reset($matches);
    }

    /**
     * @param array|string $response
     * @param int   $code
     */
    protected function render($response, int $code = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($code);
        if (is_string($response)) {
            echo $response;
            return;
        }
        echo json_encode($response);
    }

    protected function logCall(Route $route): void
    {
        if (file_exists($this->logFile)) {
            $logs = include $this->logFile;
        }
        if (!isset($logs) || !is_array($logs)) {
            $logs = [];
        }
        $logs[] = [
            'uri' => $_SERVER['REQUEST_URI'],
            'method' => $_SERVER['REQUEST_METHOD'],
            'body' => file_get_contents('php://input'),
            'matchedRoute' => $route->toArray()
        ];
        file_put_contents($this->logFile, '<?php return ' . var_export($logs, true) . ';');
    }
}
