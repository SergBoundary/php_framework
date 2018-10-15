<?php

/*
 * Copyright (C) 2017 Se Bo
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace basis\core\base;

use basis\core\Db;

/**
 * Description of Model
 *
 * @author Se Bo
 */
abstract class Model {
    protected $pdo;
    protected $table;
    protected $pk = 'id';
    public $attributes = [];
    public $errors = [];
    public $rules = [];

    public function __construct() {
        $this->pdo = Db::instance();
    }
    
    public function load($data) {
        foreach ($this->attributes as $name => $value) {
            if(isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }
    
    public function validate($data) {
        $v = new \Valitron\Validator($data);
        $v->rules($this->rules);
        if($v->validate()) {
            return TRUE;
        }
        $this->errors = $v->errors();
        return FALSE;
    }
    
    public function query($sql) {
        return $this->pdo->execute($sql);
    }
    
    public function findAll() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql);
    }
    
    public function findOne($id, $field = '') {
        if(empty($field)) { 
            $field = $this->pk;             
        }
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = ? LIMIT 1";
        return $this->pdo->query($sql, [$id]);
    }
    
    public function findBySql($sql, $params = []) {
        return $this->pdo->query($sql, $params);
    }
    
    public function findLike($str, $field, $table = '') {
        if(empty($table)) { 
            $table = $this->table;             
        }
        $sql = "SELECT * FROM {$table} WHERE {$field} LIKE ?";
        return $this->pdo->query($sql, ['%'.$str.'%']);
    }
}
