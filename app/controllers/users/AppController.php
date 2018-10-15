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

namespace app\controllers\users;

use basis\core\base\Controller;

/**
 * Description of AppController
 *
 * @author Se Bo
 */
class AppController extends Controller {
    public $interface = [];
    public $menu;
    public $meta = [];
    
    public $layout = 'admin';
    
    public function __construct($route) {
        parent::__construct($route);
        new \app\models\Main;
        $is_admin = 1;
        if(!isset($is_admin) || $is_admin !== 1) {
            header('Location: /');
//            die('Access Denied!');
        }
    }
    
    public function setInterface($language = 'ua') {
        // Маркер языка интерфейса
//        $this->interface[0] = $language;
//        // Список модулей
//        $result = \R::getAll( 'SELECT * FROM moduls');
//        $i = 1;
//        foreach ($result as $row) {
//            $this->interface['moduls'][$i] = $row['modul_'.$language];
//            $i++;
//        }
//        $result = \R::getAll( 'SELECT * FROM directions');
//        $i = 0;
//        foreach ($result as $row) {
//            $this->interface['directions'][$i] = $row['direction_'.$language];
//            $i++;
//        }
//        debug($this->interface);
    }
    
}
