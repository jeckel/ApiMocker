<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 17/09/2019
 */

namespace App\Entity;

use DateTimeInterface;

/**
 * Class ApiCallTrace
 * @package App\Entity
 */
class ApiCallTrace
{
    /** @var int|null */
    protected $api_call_trace_id;

    /** @var int|null */
    protected $matched_route_id;

    /** @var string */
    protected $path;

    /** @var string */
    protected $method;

    /** @var string */
    protected $body;

    /** @var DateTimeInterface */
    protected $received_at;

    /**
     * @return int|null
     */
    public function getApiCallTraceId(): ?int
    {
        return $this->api_call_trace_id;
    }

    /**
     * @param mixed $api_call_trace_id
     * @return ApiCallTrace
     */
    public function setApiCallTraceId($api_call_trace_id): ApiCallTrace
    {
        $this->api_call_trace_id = $api_call_trace_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMatchedRouteId(): ?int
    {
        return $this->matched_route_id;
    }

    /**
     * @param mixed $matched_route_id
     * @return ApiCallTrace
     */
    public function setMatchedRouteId($matched_route_id): ApiCallTrace
    {
        $this->matched_route_id = $matched_route_id;
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
     * @return ApiCallTrace
     */
    public function setPath(string $path): ApiCallTrace
    {
        $this->path = $path;
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
     * @return ApiCallTrace
     */
    public function setMethod(string $method): ApiCallTrace
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return ApiCallTrace
     */
    public function setBody(string $body): ApiCallTrace
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getReceivedAt(): DateTimeInterface
    {
        return $this->received_at;
    }

    /**
     * @param DateTimeInterface $received_at
     * @return ApiCallTrace
     */
    public function setReceivedAt(DateTimeInterface $received_at): ApiCallTrace
    {
        $this->received_at = $received_at;
        return $this;
    }
}
