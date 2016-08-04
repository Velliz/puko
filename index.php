<?php
/**
 * Puko Framework
 *
 * An open source MVC PHP 5 Framework for quick and fast PHP Application Development
 *
 * This content is released under the Apache Lisence 2.0
 * Copyright (c) 2016, Didit Velliz (diditvelliz@gmail.com)
 *
 */

/*
 *---------------------------------------------------------------
 * FILE ENVIRONMENT
 *---------------------------------------------------------------
 */
define('DIRECTORY', __DIR__);
define('FILE', dirname(__FILE__));

include DIRECTORY . '/config/routes.php';

var_dump(DEVELOPMENT);

include DIRECTORY . '/puko/core/Puko.php';

use puko\core\Puko;

/*
 *---------------------------------------------------------------
 * FRAMEWORK START
 *---------------------------------------------------------------
 */
Puko::Init(DEVELOPMENT)
    ->VariableDump(false)
    ->Start(array(
        //custom routes belongs here.
    ));
