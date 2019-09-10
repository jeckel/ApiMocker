<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 26/07/2019
 */

namespace App;

/**
 * Class Route
 */
class Route
{
    protected const DEFAULT_RESPONSE_CODE = 200;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    protected $response;

    /**
     * @var int
     */
    protected $responseCode = self::DEFAULT_RESPONSE_CODE;

    /**
     * Route constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->method = $config['method'];
        $this->uri = $config['uri'];
        $this->response = $config['response'];
        if (isset($config['responseCode'])) {
            $this->responseCode = $config['responseCode'];
        }
    }

    /**
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
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
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return int
     */
    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
