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

/**
 * Description of Controller
 *
 * @author Se Bo
 */
abstract class Controller {
    /**
    * текущий маршрут (controller, action, param)
    * @var array
    */
    public $route = [];
    /**
    * текущий вид
    * @var string
    */
    public $view;
    /**
    * текущий шаблон
    * @var string
    */
    public $layout;
    /**
    * пользовательские данные
    * @var array
    */
    public $vars = [];

    public function __construct($route) {
        $this->route = $route;
        $this->view = $route['action'];
    }

    public function getView() {
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars);
    }

    public function set($vars) {
        $this->vars = $vars;
    }
    
    public function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
    
    public function loadView($view, $vars = []) {
        extract($vars);
        require str_replace('/', '\\', APP."/views/{$this->route['prefix']}{$this->route['controller']}/{$view}.php");
    }
    
}
