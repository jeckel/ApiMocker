<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 26/07/2019
 */

namespace App;

use App\Exception\ExceptionInterface;
use App\Exception\RoutingException;

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
     * @return void
     */
    public function dispatch(): void
    {
        try {
            $route = $this->findMatchingRoute();
        } catch (ExceptionInterface $e) {
            $this->render(
                [
                    'error_code' => 500,
                    'error_message' => $e->getMessage()
                ],
                500
            );
            return;
        }
        $this->logCall($route);
        $this->render($route->getResponse(), $route->getResponseCode());
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
     * @return Route
     * @throws RoutingException
     */
    protected function findMatchingRoute(): Route
    {
        $matches = array_filter($this->routes, static function(Route $route) {
            return ($route->getMethod() === $_SERVER['REQUEST_METHOD']) && ($route->getUri() === $_SERVER['REQUEST_URI']);
        });
        if (count($matches) === 0) {
            throw new RoutingException(sprintf(
                'No matching route found for %s with method %s',
                $_SERVER['REQUEST_URI'],
                $_SERVER['REQUEST_METHOD']
            ));
        }

        if (count($matches) > 1) {
            throw new RoutingException(sprintf(
                'Mutliple route definition found for %s with method %s',
                $_SERVER['REQUEST_URI'],
                $_SERVER['REQUEST_METHOD']
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
        } else {
            echo json_encode($response);
        }
    }

    protected function logCall(Route $route): void
    {
        $logs = [];
        if (file_exists($this->logFile)) {
            $logs = include $this->logFile;
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
