<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 16/09/2019
 */

namespace App\Mapper;

use App\Entity\FakeRoute;

/**
 * Class RouteMockMapper
 * @package App\Mapper
 */
class FakeRouteMapper
{
    /**
     * @param FakeRoute $route
     * @param array     $data
     * @return FakeRoute
     */
    public function mapFromArray(FakeRoute $route, array $data): FakeRoute
    {
        if (isset($data['method'])) {
            $route->setMethod($data['method']);
        }
        if (isset($data['path'])) {
            $route->setPath($data['path']);
        }
        if (isset($data['expectedBody'])) {
            $route->setExpectedBody($data['expectedBody']);
        }
        if (isset($data['response'])) {
            $route->setResponse($data['response']);
        }
        if (isset($data['responseCode'])) {
            $route->setResponseCode(intval($data['responseCode']));
        }
        if (isset($data['expectedHeaders']) && is_array($data['expectedHeaders'])) {
            foreach ($data['expectedHeaders'] as $header => $value) {
                $route->addExpectedHeader($header, $value);
            }
        }
        return $route;
    }

    /**
     * @param FakeRoute $route
     * @param array     $data
     * @return FakeRoute
     */
    public function mapFromRow(FakeRoute $route, array $data): FakeRoute
    {
        $route->setId(intval($data['id']))
            ->setMethod($data['method'])
            ->setPath($data['path'])
            ->setExpectedBody(json_decode($data['expectedBody']))
            ->setExpectedHeaders(json_decode($data['expectedHeaders'], true))
            ->setResponse(json_decode($data['response']))
            ->setResponseCode(intval($data['responseCode']));
        return $route;
    }
}
