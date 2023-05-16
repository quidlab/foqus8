<?php

namespace App\Models;

use App\Exceptions\QueryException;

abstract class Model
{
    protected static $table;
    protected $fillable;
    protected static $readable;
    protected static $primaryKey;
    protected static $guardKey;
    protected $query;
    protected static $wheres = [];
    protected static $whereStr = '';
    protected $columns;



    public static function get(array $columns = []): array
    {
        if (count($columns) == 0) {
            $sql = "SELECT  [" . implode("],[", static::$readable) . "] FROM " . static::$table . static::$whereStr;
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
        $rows = "";
        foreach ($data as $key => $value) {
            $rows .= " [" . $key . "] = N'" . $value . "',";
        }
        $rows = rtrim($rows, ',');
        $sql = "UPDATE " . static::$table . " SET " . $rows . " Where [" . static::$primaryKey . "] = ?";
        try {
            return database()->Run($sql, [$primaryKey]);
        } catch (\Throwable $th) {
            throw $th;
        }
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
        static::$whereStr .= " Where [" . $column . "] " . $operator . " '" . $value . "'";
        return static::class;
    }


    public static function andWhere($column, $value = null, $operator = '='): string
    {
        static::$whereStr .= " AND [" . $column . "] " . $operator . " '" . $value . "'";
        return static::class;
    }

    public static function orWhere($column, $value = null, $operator = '='): string
    {
        static::$whereStr .= " OR [" . $column . "] " . $operator . " '" . $value . "'";
        return static::class;
    }




    /* 
    
    */
    public static function createMany(array $data, array $keys, int $per_chunk = 1000)
    {
        $availableKey = array_intersect(array_keys(reset($data)), $keys);

        $rounds = count($data) / $per_chunk;
        $affected = 0;
        for ($i = 0; $i <= $rounds; $i++) {
            $chunk = array_slice($data, $i * $per_chunk, $per_chunk);
            $affected += static::createChunk($chunk, $availableKey);
        }
        return $affected;
    }



    protected static function createChunk($chunk, $availableKey)
    {
        $cols = "[" . implode("],[", $availableKey) . "]";
        $sql = "INSERT INTO " . static::$table . " (" . $cols . ") Values ";
        $counter = 0;
        foreach ($chunk as $key => $value) {
            $vals = [];
            foreach ($value as $key => $v) {
                if (in_array($key, $availableKey)) {
                    $vals[] = $v;
                }
            }

            $vals = "'" . implode("',N'", $vals) . "'";
            $sql .= $counter++ == 0 ? '' : ',';
            $sql .= " (" . $vals . ")";
        }
        $sql .= ";";

        try {
            return database()->Run($sql, []);
        } catch (QueryException $th) {
            throw $th;
        }
    }
}
