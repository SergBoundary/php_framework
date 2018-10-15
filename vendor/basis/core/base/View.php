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
 * Description of View
 *
 * @author Se Bo
 */
class View {
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
    * перемещаемые из представлений в шаблоны скрипты 
    * @var array
    */
    public $scripts = [];
    /**
    * массив мета данных 
    * @var array
    */
//    public static $meta = ['title' => '', 'author' => '', 'copyright' => '', 'description' => '', 'keywords' => ''];
    /**
    * теги мета данных
    * @var string
    */
//    public $metaTags;
 
    public function __construct($route, $layout = '', $view = '') {
        $this->route = $route;
        if($layout === false){
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }
        $this->view = $view;
    }

    public function render($vars) {
        if(is_array($vars)) {
            extract($vars);            
        }
        $file_view = str_replace('/', '\\', APP."/views/{$this -> route['prefix']}{$this -> route['controller']}/{$this -> view}.php");
        ob_start();
        if(is_file($file_view)) {
            require $file_view;
        } else {
            throw new \Exception("Не найден вид <b>{$file_view}</b>.", 404);
        }
        $content = ob_get_clean();

        if(false !== $this->layout) {
            $file_layout = str_replace('/', '\\', APP."/views/layouts/{$this->layout}.php");
            if(is_file($file_layout)) {
                $content = $this->getScript($content);
                $scripts = [];
                if(!empty($this->scripts[0])) {
                    $scripts = $this->scripts[0];
                }
                require $file_layout;
            } else {
                throw new \Exception("Не найден шаблон <b>{$file_layout}</b>.", 404);
            }
        }
    }
    
    protected function getScript($content) {
        $pattern = "#<script.*?>.*?</script>#si";
        preg_match_all($pattern, $content, $this->scripts);
        if(!empty($this->scripts)) {
            $content = preg_replace($pattern, '', $content);
        }
        return $content;
    }
    
}
