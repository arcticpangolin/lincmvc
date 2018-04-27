<?php

/**
* Core Model
*
* @version PHP 7
*
* @package COREphp
* @author John Lincoln <jlincoln88@gmail.com>
* @copyright 2018 Arctic Pangolin
*/

namespace Core;

use PDO;
use App\Config;

abstract class Model
{

  /**
   * Gets an intantiated PDO object
   *
   * @return PDO
   */
    protected static function getDB()
    {
        static $db = null;
        if ($db === null) {
            $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8';
            $db = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        }
    }
}
