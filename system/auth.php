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
 * Description of auth.php
 *
 * HTTP request authentication page
 * 
 * @author Amit
 */

if (API_KEY === 'yes') {
    // Check HTTP request and collect key and value
    if (REQUEST === 'POST') {
        if (!is_null(filter_input(INPUT_POST, 'ikey')) && ctype_alnum(filter_input(INPUT_POST, 'ikey')) && !is_null(filter_input(INPUT_POST, 'ipass')) && ctype_alnum(filter_input(INPUT_POST, 'ipass'))) {
            $key = filter_input(INPUT_POST, 'ikey', FILTER_SANITIZE_STRING);
            $value = filter_input(INPUT_POST, 'ipass', FILTER_SANITIZE_STRING);
        } else {
            header('HTTP/1.1 401 Unauthorized.', TRUE, 401);
            echo 'You are not authorised to access this page.';
            exit(1); // EXIT_ERROR 
        }
    } elseif (REQUEST === 'GET') {
        if (!is_null(filter_input(INPUT_GET, 'ikey')) && ctype_alnum(filter_input(INPUT_GET, 'ikey')) && !is_null(filter_input(INPUT_GET, 'ipass')) && ctype_alnum(filter_input(INPUT_GET, 'ipass'))) {
            $key = filter_input(INPUT_GET, 'ikey', FILTER_SANITIZE_STRING);
            $value = filter_input(INPUT_GET, 'ipass', FILTER_SANITIZE_STRING);
        } else {
            header('HTTP/1.1 401 Unauthorized.', TRUE, 401);
            echo 'You are not authorised to access this page.';
            exit(1); // EXIT_ERROR 
        }
    } else {
        header('HTTP/1.1 401 Unauthorized.', TRUE, 401);
        echo 'You are not authorised to access this page.';
        exit(1); // EXIT_ERROR 
    }
    //Depending on authentication method validate key-value pair
    if (AUTH_TYPE === 'plain') {
        $authorizer = array(
            'user1' => '65h4g9874h65464h894hg65487h64',
            'user2' => 'gfd46165fdh897yt6541616df7rer',
            'user3' => 'gg8971646uo561dfh546d78te564r',
            'user4' => 'uku55fh156456j3213gd1651af654'
        );
        if (isset($authorizer[$key]) && strcmp($authorizer[$key], $value) !== 0) {
            header('HTTP/1.1 401 Unauthorized.', TRUE, 401);
            echo 'You are not authorised to access this page.';
            exit(1); // EXIT_ERROR 
        }
    } elseif (AUTH_TYPE === 'db') {
        require_once SYS_PATH . 'dbConfig.php';
        $dbc = new DBC(0); // 0 defines database id in dbConfig.php
        $db = $dbc->getConnection();
        $db->exec("SET CHARACTER SET utf8");
        try {
            $sql = "SELECT id FROM `users` WHERE `key`= ? AND `pass`= ?";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($key, $value));
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $stmt->fetchAll();
            if (empty($rows)) {
                header('HTTP/1.1 401 Unauthorized.', TRUE, 401);
                echo 'You are not authorised to access this page.';
                exit(1); // EXIT_ERROR 
            }
            $dbc->closeConnection();
        } catch (PDOException $e) {
            header('HTTP/1.1 401 Unauthorized.', TRUE, 401);
            echo 'You are not authorised to access this page.';
            exit(1); // EXIT_ERROR 
        }
    } else {
        header('HTTP/1.1 401 Unauthorized.', TRUE, 401);
        echo 'You are not authorised to access this page.';
        exit(1); // EXIT_ERROR  
    }
}
