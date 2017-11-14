<?php

namespace App\Models;

use PDO;
use Core\Model;

/**
 *
 * Model SampleModel
 * model for the "sample" data
 *
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