<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 16/09/2019
 */

namespace App\Entity;

use Fig\Http\Message\StatusCodeInterface;
use JsonSerializable;

/**
 * Class RouteMock
 * @package App\Entity
 */
class RouteMock implements JsonSerializable
{
    /** @var int|null */
    protected $route_id;

    /** @var string */
    protected $method;

    /** @var string */
    protected $path;

    /** @var string|array|null */
    protected $expectedBody;

    /** @var array */
    protected $expectedHeaders = [];

    /** @var mixed */
    protected $response;

    /** @var int */
    protected $responseCode = StatusCodeInterface::STATUS_OK;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->route_id;
    }

    /**
     * @param int $route_id
     * @return RouteMock
     */
    public function setId(int $route_id): RouteMock
    {
        $this->route_id = $route_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return RouteMock
     */
    public function setMethod(string $method): RouteMock
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return RouteMock
     */
    public function setPath(string $path): RouteMock
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return array|string|null
     */
    public function getExpectedBody()
    {
        return $this->expectedBody;
    }

    /**
     * @param array|string|null $expectedBody
     * @return RouteMock
     */
    public function setExpectedBody($expectedBody): RouteMock
    {
        $this->expectedBody = $expectedBody;
        return $this;
    }

    /**
     * @return array
     */
    public function getExpectedHeaders(): array
    {
        return $this->expectedHeaders;
    }

    /**
     * @param array $expectedHeaders
     * @return RouteMock
     */
    public function setExpectedHeaders(array $expectedHeaders): RouteMock
    {
        $this->expectedHeaders = $expectedHeaders;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     * @return RouteMock
     */
    public function setResponse($response): RouteMock
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return int
     */
    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    /**
     * @param int $responseCode
     * @return RouteMock
     */
    public function setResponseCode(int $responseCode): RouteMock
    {
        $this->responseCode = $responseCode;
        return $this;
    }

    /**
     * @param string $header
     * @param string $value
     * @return RouteMock
     */
    public function addExpectedHeader(string $header, string $value): RouteMock
    {
        $this->expectedHeaders[$header] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
