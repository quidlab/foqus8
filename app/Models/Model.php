<?php
namespace App\Models;

abstract class Model{
    protected $table;
    protected $fillable = [];
    protected $columns;
    

    public function get($columns = ['*']){
        
    }
    
}