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
 * Description of httpResponse
 *
 * Build HTTP response
 * 
 * @author Amit
 */

/*
 * ---------------------------------------------------------------
 * FUNCTION RESPONSE
 * ---------------------------------------------------------------
 * 
 */

function _response($code, $format, $status, $obj = null, $method = null, $paraArray = null) {

    // Define HTTP responses
    $http_response_code = array(
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found'
    );

    // Set HTTP Response
    header('HTTP/1.1 ' . $status . ' ' . $http_response_code[$status]);
    header("Cache-Control: no-cache, must-revalidate");

    // Set HTTP Response Format
    switch ($format) {
        case 'text':
            header('Content-Type: text/plain; charset=utf-8');
            break;
        case 'json':
            header('Content-Type: application/json; charset=utf-8');
            break;
        case 'html':
        default:
            header('Content-Type: text/html; charset=utf-8');
            break;
    }

    // Check Success code
    if ($code === 1) {
        if (method_exists($obj, $method)) {
            $result = call_user_func_array(array($obj, $method), $paraArray);
        } else {
            $status = 400;
            // Replacement header
            header('HTTP/1.1 ' . $status . ' ' . $http_response_code[$status]);
            $result = "Requested URL Not Found.";
        }
    } else {
        // Custom Status Messages
        switch ($status) {
            case 400:
                $result = "Requested URL Not Found.";
                break;
            case 401:
                $result = "You Are Not Authorized To Access This Page.";
                break;
            case 403:
                $result = "You Are Not Authorized To Access This Page.";
                break;
            case 404:
                $result = "Requested Page Not Found.";
                break;
            default:
                $result = "Failed To Process Your Request.";
                break;
        }
    }
    switch ($format) {
        case 'text':
            echo $result;
            break;
        case 'json':
            echo json_encode($result);
            break;
        case 'html':
        default:
            echo $result;
            break;
    }
    exit;
}
