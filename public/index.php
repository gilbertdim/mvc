<?php

/**
 * Front controller
 */

/**
 * Composer Autoload
 */
require_once dirname(__DIR__).'/vendor/autoload.php';

/**
 * Error and Exception handler
 */

set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


$router = new Core\Router;

require_once dirname(__DIR__).'/Routes/web.php';

$router->dispatch($_SERVER['QUERY_STRING']);