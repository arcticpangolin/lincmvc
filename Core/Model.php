<?php

/**
* Core Model
*
* PHP 7
* Written by John Lincoln 2017
*/

namespace Core;

use PDO;
use App\Config;

abstract class Model
{

  /**
   * Gets an intantiated PDO object connected to the app's database.
   *
   * @return PDO
   */
    protected static function getDB()
    {
        static $db = null;
        if ($db === null) {
            $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8';
            $db = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); #set PDO to throw exceptions
            return $db;
        }
    }
}
