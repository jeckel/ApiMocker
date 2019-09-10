<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 10/09/2019
 */

namespace App\Entity;

/**
 * Class RouteConfig
 * @package App\Entity
 */
class RouteConfig
{
    /** @var string */
    protected $method;

    /** @var string */
    protected $path;

    /**
     * Route constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->method = $config['method'];
        $this->path = $config['uri'];
//        $this->response = $config['response'];
//        if (isset($config['responseCode'])) {
//            $this->responseCode = $config['responseCode'];
//        }
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
