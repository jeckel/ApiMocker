<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 10/09/2019
 */

namespace App;

use App\Entity\RouteConfig;
use App\Exception\RoutingException;
use Psr\Http\Message\RequestInterface;

/**
 * Class RouteConfigRepository
 * @package App
 */
class RouteConfigRepository
{
    /**
     * @var RouteConfig[]
     */
    protected $routeConfigs = [];

    /**
     * @param RouteConfig $routeConfig
     * @return RouteConfigRepository
     */
    public function addRouteConfig(RouteConfig $routeConfig): self
    {
        $this->routeConfigs[] = $routeConfig;
        return $this;
    }

    /**
     * @param RequestInterface $request
     * @return RouteConfig
     */
    public function getRouteConfigByRequest(RequestInterface $request): RouteConfig
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        $matches = array_filter(
            $this->routeConfigs,
            static function (RouteConfig $route) use ($method, $path) {
                return ($route->getMethod() === $method) &&
                    ($route->getPath() === $path);
            }
        );

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
}
