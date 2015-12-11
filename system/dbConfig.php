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
 * Description of dbConfig.php
 *
 * Database selection and connection page
 * 
 * @author Amit
 */

/*
 * --------------------------------------------------------------------
 * DATABASE DRIVERS
 * --------------------------------------------------------------------
 * 
 * Defult Database settings to be used.
 * 
 * Include any number of database connection and pass $db_id to use it.
 * 
 */

class DBC {
	
    const TESTING_DB = 0;
    const PRODUCTION_DB = 1;

    var $config = array(
        0 => array(
            'driver' => 'PDO',
            'host' => '',
            'user' => '',
            'password' => '',
            'database' => ''),
        1 => array(
            'driver' => 'OOP',
            'host' => '',
            'user' => '',
            'password' => '',
            'database' => ''),
        2 => array(
            'driver' => 'FUNC',
            'host' => '',
            'user' => '',
            'password' => '',
            'database' => '')
    );

    var $db_id = 0;
    var $db = null;

    function __construct($db_id = 0) {
        $this->db_id = $db_id;
        switch ($this->config[$db_id]['driver']) {
            case 'PDO':
                $this->db = new PDO("mysql:host=" . $this->config[$db_id]['host'] . ";dbname=" . $this->config[$db_id]['database'], $this->config[$db_id]['user'], $this->config[$db_id]['password']);
                break;
            case 'OOP':
                $this->db = new mysqli($this->config[$db_id]['host'], $this->config[$db_id]['user'], $this->config[$db_id]['password'], $this->config[$db_id]['database']);
                break;
            case 'FUNC':
                $this->db = mysqli_connect($this->config[$db_id]['host'], $this->config[$db_id]['user'], $this->config[$db_id]['password'], $this->config[$db_id]['database']);
                break;
        }
    }

    function getConnection() {
        return $this->db;
    }

    function closeConnection() {
        if (!empty($this->db)) {
            switch ($this->config[$this->db_id]['driver']) {
                case 'PDO':
                    $this->db = NULL;
                    break;
                case 'OOP':
                    $this->db->close();
                    break;
                case 'FUNC':
                    mysqli_close($this->db);
                    break;
            }
        }
    }

}
