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

    try {
      
      $db = static::getDB();

      $query = $db->query('select * from sample');

      $results = $query->fetchAll(PDO::FETCH_ASSOC);

      return $results;
      
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
    }
  }


}