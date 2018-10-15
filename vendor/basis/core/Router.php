<?php

/**
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

class Router {
    
    /**
    * таблица маршрутов
    * @var array
    */
    protected static $routes = [];
    /**
    * текущий маршрут
    * @var array
    */
    protected static $route = [];
    /**
    * добавляем маршрут в таблицу маршрутов
    * @param string $regexp регулярное выражение маршрута
    * @param array $route маршрут (controller, action, param)
    */
    public static function add($regexp, $route = []) {
        self::$routes[$regexp] = $route;
    }
    /**
    * возвращает таблицу маршрутов
    * 
    * @return array
    */
    public static function getRoutes() {
        return self::$routes;
    }

    public static function getRoute() {
            return self::$route;
    }
    /**
    * ищет URL в таблице маршрутов
    * @param string $url входящий URL
    * @return boolean
    */
    public static function matchRoute($url) {
        foreach(self::$routes as $pattern => $route) {
            if(preg_match("#$pattern#i", $url, $matches)) {
//                debug($matches);
                foreach($matches as $key => $value) {
                    if(is_string($key)) {
                        $route[$key] = $value;
                    }
                }
                if(!isset($route['action'])) {
                    $route['action'] = 'news';
                }
                // prefix for user controllers
                if(!isset($route['prefix'])) {
                    $route['prefix'] = '';
                } else {
                    $route['prefix'] .= '\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }
    /**
    * перенаправляет URL по корректному маршруту
    * @param string $url входящий URL
    * @return void
    */
    public static function dispatch($url) {
        $url = self::removeQueryString($url);
        if(self::matchRoute($url)) {
            $controller = 'app\controllers\\'.self::$route['prefix'].self::$route['controller'].'Controller';
//            debug($controller);
            if(class_exists($controller)) {
                $cObj = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']).'Action';
                if(method_exists($cObj, $action)) {
                    $cObj->$action();
                    $cObj->getView();
                } else {
                    throw new \Exception("Метод <b>{$controller::$action}</b> не найден.", 404);
                }
            } else {
                throw new \Exception("Контроллер <b>{$controller}</b> не найден.", 404);
            }
        } else {
            throw new \Exception("Страница не найдена.", 404);
        }
    }

    protected static function upperCamelCase($name) {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    protected static function lowerCamelCase($name) {
        return lcfirst(self::upperCamelCase($name));
    }

    protected static function removeQueryString($url) {
        if($url) {
            $params = explode('&', $url, 2);
            if(false === strpos($params[0], '=')) {
                return trim($params[0], '/');
            } else {
                return '';
            }
        }
    }
    
}
