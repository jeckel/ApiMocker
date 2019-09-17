<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 17/09/2019
 */

namespace App\Repository;

use App\Entity\ApiCallTrace;
use PDO;

/**
 * Class ApiCallTraceRepository
 * @package App\Repository
 */
class ApiCallTraceRepository
{
    /** @var PDO */
    protected $pdo;

    /**
     * ApiCallTraceRepository constructor.
     * @param PDO $pdo
     */
    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }

    /**
     * @param ApiCallTrace $trace
     * @return ApiCallTrace
     */
    public function save(ApiCallTrace $trace): ApiCallTrace
    {
        if ($trace->getApiCallTraceId() === null) {
            return $this->insert($trace);
        }
        return $this->update($trace);
    }

    /**
     * @param ApiCallTrace $trace
     * @return ApiCallTrace
     */
    public function insert(ApiCallTrace $trace): ApiCallTrace
    {
        $stmt = $this->pdo->prepare('INSERT INTO api_call_trace
            (route_id, path, method, body, received_at)
            VALUES (:route_id, :path, :method, :body, :received_at)');
        $stmt->execute([
            ':route_id' => $trace->getMatchedRouteId(),
            ':path' => $trace->getPath(),
            ':method' => $trace->getMethod(),
            ':body' => $trace->getBody(),
            ':received_at' => $trace->getReceivedAt()->format('Y-m-d H:i:s')
        ]);
        $trace->setApiCallTraceId(intval($this->pdo->lastInsertId()));
        return $trace;
    }

    /**
     * @param ApiCallTrace $trace
     * @return ApiCallTrace
     */
    public function update(ApiCallTrace $trace): ApiCallTrace
    {
        $stmt = $this->pdo->prepare('UPDATE api_call_trace SET 
            route_id = :route_id,
            path = :path,
            method = :method,
            body = :body,
            received_at = :received_at
            WHERE id = :id');
        $stmt->execute([
            ':id' => $trace->getApiCallTraceId(),
            ':route_id' => $trace->getMatchedRouteId(),
            ':path' => $trace->getPath(),
            ':method' => $trace->getMethod(),
            ':body' => $trace->getBody(),
            ':received_at' => $trace->getReceivedAt()->format('Y-m-d H:i:s')
        ]);
        return $trace;
    }
}
