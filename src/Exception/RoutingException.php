<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 26/07/2019
 */

namespace App\Exception;

use RuntimeException;

/**
 * Class RoutingException
 * @package App\Exception
 */
class RoutingException extends RuntimeException implements ExceptionInterface
{

}
