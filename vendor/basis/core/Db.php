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

namespace basis\core;

/**
 * Description of Db
 *
 * @author Se Bo
 */
class Db {
    
    use TSingletone;
    
    protected $pdo;
    public static $countSql = 0;
    public static $queries = [];

//    protected function __construct() {
//        $db = require ROOT.'/config/config_db.php';
//        require LIBS.'/rb.php';
//        \R::setup($db['dsn'], $db['user'], $db['pass']);
//        \R::testConnection() or die('No Connection...');
//        \R::freeze(TRUE);
////        \R::fancyDebug(TRUE);
//    }

    protected function __construct() {
        $db = require ROOT.'/config/config_db.php';
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];
        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass'], $options);
    }
    
//    public static function instance() {
//        if(self::$instance === null){
//            self::$instance = new self;
//        }
//        return self::$instance;
//    }
    
    public function execute($sql, $params = []) {
        self::$countSql++;
        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    public function query($sql, $params = []) {
        self::$countSql++;
        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute($params);
        if($res !== false) {
            return $stmt->fetchAll();
        }
        return [];
     }
    
}
