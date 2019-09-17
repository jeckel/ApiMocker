<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 16/09/2019
 */

namespace App\Mapper;

use App\Entity\RouteMock;

/**
 * Class RouteMockMapper
 * @package App\Mapper
 */
class RouteMockMapper
{
    /**
     * @param RouteMock $route
     * @param array     $data
     * @return RouteMock
     */
    public function mapFromArray(RouteMock $route, array $data): RouteMock
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
}
