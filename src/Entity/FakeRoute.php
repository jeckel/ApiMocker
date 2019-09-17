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
class FakeRoute implements JsonSerializable
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
     * @return FakeRoute
     */
    public function setId(int $route_id): FakeRoute
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
     * @return FakeRoute
     */
    public function setMethod(string $method): FakeRoute
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
     * @return FakeRoute
     */
    public function setPath(string $path): FakeRoute
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
     * @return FakeRoute
     */
    public function setExpectedBody($expectedBody): FakeRoute
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
     * @return FakeRoute
     */
    public function setExpectedHeaders(array $expectedHeaders): FakeRoute
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
     * @return FakeRoute
     */
    public function setResponse($response): FakeRoute
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
     * @return FakeRoute
     */
    public function setResponseCode(int $responseCode): FakeRoute
    {
        $this->responseCode = $responseCode;
        return $this;
    }

    /**
     * @param string $header
     * @param string $value
     * @return FakeRoute
     */
    public function addExpectedHeader(string $header, string $value): FakeRoute
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
