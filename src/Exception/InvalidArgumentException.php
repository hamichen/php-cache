<?php
declare(strict_types=1);

namespace Hami\Cache\Exception;

use Exception;
use \Psr\Cache\InvalidArgumentException as InvalidArgumentExceptionInterface;

/**
 * Class InvalidArgumentException
 *
 * @package Hami\Cache
 */
class InvalidArgumentException extends Exception implements InvalidArgumentExceptionInterface {
}
