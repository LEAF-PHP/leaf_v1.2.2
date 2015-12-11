<?php

/*
 * LEAF (Lightweight Easy Application Framework)
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2015 - 2016 AmitPatil Codes.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *  @package   Leaf
 *  @copyright Copyright (c) 2015 - 2016, AmitPatil Codes
 *  @link  http://amitpatil.net/leaf
 *  @since	Version 1.2.2
 */

/**
 * Description of index.php
 *
 * Main page accepting user request
 * 
 * @author Amit
 */

/*
 * ---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 * ---------------------------------------------------------------
 *
 *     development
 *     testing
 *     production
 *     maintenance
 *
 */

define('ENVIRONMENT', isset($_SESSION['APP_ENV']) ? $_SESSION['APP_ENV'] : 'development');

/*
 * ---------------------------------------------------------------
 * ERROR REPORTING
 * ---------------------------------------------------------------
 */

switch (ENVIRONMENT) {
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;
    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>=')) {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        } else {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        }
        break;
    case 'maintenance':
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment. We&rsquo;ll be back online shortly!';
        exit(1); // EXIT_ERROR
        break;
    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1); // EXIT_ERROR
}

/*
 * ---------------------------------------------------------------
 * FOLDERS AND PATH
 * ---------------------------------------------------------------
 */
define('APP_PATH_SEPARATOR', '/');

$system_dir = 'system';
$application_dir = 'application';
$controller_dir = 'controllers';
$models_dir = 'models';
$view_dir = 'views';

define('BASE_PATH', __DIR__ . APP_PATH_SEPARATOR);
define('SYS_PATH', BASE_PATH . $system_dir . APP_PATH_SEPARATOR);
define('APP_PATH', BASE_PATH . $application_dir . APP_PATH_SEPARATOR);
define('CONTROLLER_PATH', APP_PATH . $controller_dir . APP_PATH_SEPARATOR);
define('MODEL_PATH', APP_PATH . $models_dir . APP_PATH_SEPARATOR);
define('VIEW_PATH', APP_PATH . $view_dir . APP_PATH_SEPARATOR);

if (!is_dir(SYS_PATH) || !is_dir(APP_PATH) || !is_dir(CONTROLLER_PATH) || !is_dir(MODEL_PATH) || !is_dir(VIEW_PATH)) {

    header('HTTP/1.1 404 Not Found.', TRUE, 404);
    echo 'The Application can not find specified directory or path.';
    exit(3); // EXIT_CONFIG
}

/*
 * --------------------------------------------------------------------
 * CHECK FOR HTTP REQUEST
 * --------------------------------------------------------------------
 * 
 */
define('REQUEST', filter_input(INPUT_SERVER, 'REQUEST_METHOD'));

/*
 * --------------------------------------------------------------------
 * LOAD CORE FILES
 * --------------------------------------------------------------------
 */
require_once SYS_PATH . 'config.php';
require_once SYS_PATH . 'auth.php';
require_once SYS_PATH . 'httpResponse.php';

// Set default format
$format = DEFAULT_RESPONSE;

// Function call
if (REQUEST === 'POST') {
    $format = !is_null(filter_input(INPUT_POST, 'iformat')) && in_array(filter_input(INPUT_POST, 'iformat'), $allowed_responses) ? filter_input(INPUT_POST, 'iformat') : DEFAULT_RESPONSE;
    if (!is_null(filter_input(INPUT_POST, 'ipage')) && preg_match('/[a-zA-Z0-9_]/', filter_input(INPUT_POST, 'ipage'))) {
        // Can replace strtolower() function with strtoupper().
        $class = CHANGE_CLASS_CASE ? strtolower(filter_input(INPUT_POST, 'ipage')) : filter_input(INPUT_POST, 'ipage');
        // Php (controller) file to be included
        $page = CONTROLLER_PREFIX . $class . '.php';
        if (file_exists(CONTROLLER_PATH . $page)) {
            include_once CONTROLLER_PATH . $page;
            if (!is_null(filter_input(INPUT_POST, 'imethod')) && preg_match('/[a-zA-Z0-9_]/', filter_input(INPUT_POST, 'imethod'))) {
                _response(1, $format, 200, new $class(), filter_input(INPUT_POST, 'imethod') . '_post', requestArrayFilter($_POST));
            } else {
                _response(0, $format, 400);
            }
        } else {
            _response(0, $format, 404);
        }
    } else {
        _response(0, $format, 400);
    }
} else {
    $format = !is_null(filter_input(INPUT_GET, 'iformat')) && in_array(filter_input(INPUT_GET, 'iformat'), $allowed_responses) ? filter_input(INPUT_GET, 'iformat') : DEFAULT_RESPONSE;
    if (!is_null(filter_input(INPUT_GET, 'ipage')) && preg_match('/[a-zA-Z0-9_]/', filter_input(INPUT_GET, 'ipage'))) {
        // Can replace strtolower() function with strtoupper().
        $class = CHANGE_CLASS_CASE ? strtolower(filter_input(INPUT_GET, 'ipage')) : filter_input(INPUT_GET, 'ipage');
        // Php (controller) file to be included
        $page = CONTROLLER_PREFIX . $class . '.php';
        if (file_exists(CONTROLLER_PATH . $page)) {
            include_once CONTROLLER_PATH . $page;
            if (!is_null(filter_input(INPUT_GET, 'imethod')) && preg_match('/[a-zA-Z0-9_]/', filter_input(INPUT_GET, 'imethod'))) {
                _response(1, $format, 200, new $class(), filter_input(INPUT_GET, 'imethod') . '_get', requestArrayFilter($_GET));
            } else {
                _response(0, $format, 400);
            }
        } else {
            _response(0, $format, 404);
        }
    } else {
        _response(0, $format, 400);
    }
}

// Filter reserve keywords from request string
function requestArrayFilter($requestArray) {
    $paraArray = array();
    foreach ($requestArray as $key => $value) {
        if (!in_array($key, array('ipage', 'imethod', 'ikey', 'ipass', 'iformat'))) {
            $paraArray[0][$key]= $value;
        }
    }
    return $paraArray;
}

// Function to debug
function logger($msg) {
    $file = fopen(BASE_PATH . "log.txt", "a");
    fwrite($file, date('D, d M Y H:i:s') . ": " . $msg . "\n");
    fclose($file);
}
