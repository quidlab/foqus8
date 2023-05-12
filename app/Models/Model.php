<?php

namespace App\Models;

use App\Exceptions\QueryException;

abstract class Model
{
    protected static $table;
    protected static $fillable;
    protected static $readable;
    protected static $primaryKey;
    protected static $guardKey;
    protected static $query;
    protected static $wheres = [];
    protected $columns;


    public static function get(array $columns = []):array
    {
        $wheres = "";
        foreach (static::$wheres as $key => $value) {
            $wheres .= " Where [" . $value['column'] . "] " . $value['operator'] . " '" . $value['value'] . "'";
        }
        if (count($columns) == 0) {
            $sql = "SELECT  [" . implode("],[", static::$readable) . "] FROM " . static::$table . $wheres;
        } else {
            $sql = "SELECT  [" . implode("],[", $columns) . "] FROM " . static::$table;
        }
        try {
            $result = database()->Select($sql, []);
            return $result == null ? [] : $result;
        } catch (QueryException $th) {
            throw $th;
        }
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



    /* 
    
    */
    public static function delete($primaryKey)
    {
        $sql = "DELETE FROM " . static::$table . " WHERE [" . static::$primaryKey . "] = ?";
        return database()->Run($sql, [$primaryKey]);
    }

    /* 
    
    */
    public static function deleteByColName(string $colName, $colValue)
    {
        $sql = "DELETE FROM " . static::$table . " WHERE [" . $colName . "] = ?";

        try {
            return database()->Run($sql, [$colValue]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /* 
    
    */
    public static function find($primaryKey)
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE [" . static::$primaryKey . "] = ?";
        return database()->Run($sql, [$primaryKey]);
    }

    /* 
    
    */
    public static function update(array $data, $primaryKey = null)
    {
        $primaryKey = $primaryKey == null ? static::$primaryKey : $primaryKey;
        return $sql = "UPDATE " . static::$table . " SET " . http_build_query($data, '', ', ') . " Where " . static::$primaryKey . " = ?";
        return database()->Run($sql, [$data[$primaryKey]]);
    }

    /* 
    
    */
    public static function getByColName(string $colName, $colValue): array
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE [" . $colName . "] = ?";
        $results =  database()->Select($sql, [$colValue]);
        $data = [];
        if ($results) {
            foreach ($results as $key => $result) {
                $data[] = (object) $result;
            }
        }
        return $data;
    }

    /* 
    
    */
    public static function findByColName(string $colName, $colValue): object|null|bool
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE [" . $colName . "] = ?";
        $results =  database()->Select($sql, [$colValue]);
        $data = null;
        if ($results && count($results)) {
            $data = (object) $results[0];
        }
        return $data;
    }



    /* 
    
    */
    protected static function formatter($results)
    {
        return  $results;
    }


    public static function where($column, $value = null, $operator = '=')
    {
        static::$wheres[] = compact('column', 'operator', 'value');
        return static::class;
    }
}
