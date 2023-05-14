<?php

namespace App\Models;

use App\Exceptions\QueryException;

abstract class Model
{
    protected static $table;
    protected $fillable;
    protected static $readable;
    protected $primaryKey;
    protected $guardKey;
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
    public function create(array $data)
    {
        $keys = array_keys($data);
        $values = array_values($data);

        $cols = "[" . implode("],[", $keys) . "]";
        $vals = "'" . implode("','", $values) . "'";

        $sql = "INSERT INTO " . $this->table . " (" . $cols . ") Values(" . $vals . ") ;";
        return database()->Run($sql, []);
    }



    /*
    
    */
    public function delete($primaryKey)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE [" . $this->primaryKey . "] = ?";
        return database()->Run($sql, [$primaryKey]);
    }

    /*
    
    */
    public function deleteByColName(string $colName, $colValue)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE [" . $colName . "] = ?";

        try {
            return database()->Run($sql, [$colValue]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
    
    */
    public function find($primaryKey)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE [" . $this->primaryKey . "] = ?";
        return database()->Run($sql, [$primaryKey]);
    }

    /* 
    
    */
    public function update(array $data, $primaryKey = null)
    {
        $primaryKey = $primaryKey == null ? $this->primaryKey : $primaryKey;
        return $sql = "UPDATE " . $this->table . " SET " . http_build_query($data, '', ', ') . " Where " . $this->primaryKey . " = ?";
        return database()->Run($sql, [$data[$primaryKey]]);
    }

    /* 
    
    */
    public function getByColName(string $colName, $colValue): array
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE [" . $colName . "] = ?";
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
    public function findByColName(string $colName, $colValue): object|null|bool
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE [" . $colName . "] = ?";
        $results =  database()->Select($sql, [$colValue]);
        $data = null;
        if ($results && count($results)) {
            $data = (object) $results[0];
        }
        return $data;
    }



    /* 
    
    */
    protected function formatter($results)
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
}
