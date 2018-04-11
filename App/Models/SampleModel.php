<?php
/**
 * Sample Model
 *
* @version PHP 7
*
* @example Model
* @package COREphp
* @author John Lincoln <jlincoln88@gmail.com>
* @copyright 2018 Arctic Pangolin
 */
namespace App\Models;

use PDO;
use Core\Model;

class SampleModel extends Model
{
    /**
     * Gets all of the samples from the sample table
     *
     * @return array
     */
    public static function getAll()
    {
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
