<?php

namespace App\Models;

abstract class Model
{
    protected static $table;
    protected static $fillable;
    protected static $readable;
    protected static $primaryKey;
    protected $columns;


    public static function get($columns = '*')
    {
        if ($columns == '*') {
            $sql = "SELECT  [" . implode("],[", static::$readable) . "] FROM " . static::$table;
        }
        return self::formatter(database()->Select($sql, []));
    }


    /* 
    
    */
    public static function create(array $data)
    {
        $keys = array_keys($data);
        $values = array_values($data);

        $cols = "[" . implode("],[", $keys) . "]";
        $vals = "'" . implode("','", $values) . "'";

        $sql = "INSERT INTO " . static::$table . " (" . $cols . ") Values(" . $vals . ") ;";
        return database()->Run($sql, []);
    }




    public static function delete($primaryKey)
    {
        $sql = "DELETE FROM " . static::$table . " WHERE [".static::$primaryKey."] = ?";
        return database()->Run($sql, [$primaryKey]);
    }
    /* 
    
    */
    protected static function formatter($results)
    {
        return  $results;
    }
}
