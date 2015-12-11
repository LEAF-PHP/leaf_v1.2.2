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
 * Description of config.php
 *
 * Main configuration page
 * 
 * @author Amit
 */

/*
 * --------------------------------------------------------------------
 * URL
 * --------------------------------------------------------------------
 * 
 */

define('WEB_URL', 'http://localhost/LEAF/');


/*
 * ---------------------------------------------------------------
 * API KEY
 * ---------------------------------------------------------------
 * 
 * API Key is case-sensetive. 
 * 
 * Disable API Key checking by keeping API_KEY blank.
 * 
 * If enabled, check .htaccess file for some changes
 * 
 */

define('API_KEY', 'no');


/*
 * ---------------------------------------------------------------
 * AUTHENTICATION TYPE
 * ---------------------------------------------------------------
 * 
 * Authentication Type
 * 
 * plain : Use array of key => value from auth.php file
 * db    : Use table of key and value pair in database
 * 
 */

define('AUTH_TYPE', 'db');

/*
 * --------------------------------------------------------------------
 * CONTROLLER FILE PREFIX
 * --------------------------------------------------------------------
 * 
 * Prefix in controller file is used for security reason only, keep blank if not required.
 * If provided, add it to each controllers name.
 * 
 */

define('CONTROLLER_PREFIX', 'cp_');

/*
 * --------------------------------------------------------------------
 * CLASS NAME CASE
 * --------------------------------------------------------------------
 * 
 * Prefix in controller file is used for security reason only, keep blank if not required.
 * If provided, add it to each controllers name.
 * 
 */

define('CHANGE_CLASS_CASE', TRUE);


/*
 * --------------------------------------------------------------------
 * DEFAULT TIME ZONE
 * --------------------------------------------------------------------
 */
date_default_timezone_set("Asia/Kolkata");


/*
 * --------------------------------------------------------------------
 * DEFAULT RESPONSE FORMAT
 * --------------------------------------------------------------------
 */
define('DEFAULT_RESPONSE', 'html');

/*
 * --------------------------------------------------------------------
 * ALLOWED RESPONSES
 * --------------------------------------------------------------------
 */
$allowed_responses = array('html', 'text', 'json');
