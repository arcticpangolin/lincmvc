<?php

namespace App\Models;

use PDO;
use Core\Model;

/**
* sample model class
*/
class SampleModel extends Model
{
  
  public static function getAll() {
    // $host = 'localhost';
    // $dbname = 'mvc';
    // $username = 'root';
    // $password = 'root';

    try {
      //$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$username,$password);
      $db = static::getDB();

      $query = $db->query('select * from sample');

      $results = $query->fetchAll(PDO::FETCH_ASSOC);

      return $results;
      
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
    }
  }


}