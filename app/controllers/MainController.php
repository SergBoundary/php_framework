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

namespace app\controllers;

//use app\models\Main;
use basis\core\App;
//use vendor\core\base\Controller;
use basis\core\base\View;
use app\controllers\AppController;

/**
 * Description of MainController
 *
 * @author Se Bo
 */
class MainController extends AppController {
	
    public $layout = 'main';
    public $language;
    public $meta;
    public $interface = [];
    public $authors = [];

    public function __construct($route) {
        parent::__construct($route);
        // Открытие сессии
        session_start();
        // Получение выбранного пользователем языка интерфейса
        if(isset($_POST['language'])) {
            $this->language = $_POST['language'];
            $_SESSION['language'] = $_POST['language'];
        } else {
            if(isset($_SESSION['language'])) {
                $this->language = $_SESSION['language'];
            } else {
                $this->language = 'ua';
            }
        }
        // Получение массива слов на выбранном пользователем языке
        $this->interface = App::$app->cache->get('interface');
        if(!$this->interface || $this->interface[0] != $this->language) {
            $this->setInterface($this->language);
            App::$app->cache->set('interface', $this->interface);
        }
        // Получение массива данных авторов на выбранном пользователем языке
        $this->authors = App::$app->cache->get('authors');
        if(!$this->authors || $this->authors[0] != $this->language) {
            $this->setAuthors($this->language);
            App::$app->cache->set('authors', $this->authors);
        }
//            debug($this->authors);
    }
        
    public function newsAction() {
        $this->view = 'news';
        $language = $this->language;
        $interface = $this->interface;
//        debug($interface);
        
        $this->setMeta('Платформа', 'Se Bo', date('Y').', Se Bo', 'Страница критического и библиотечного контента', 'мероприятия, критика, библиотека');
        $meta = $this->meta;
        $path = ucwords($this->layout).' / '.ucwords($this->view);
        $post = [];
        $this->set(compact('language', 'interface', 'meta', 'path', 'post'));
    }
        
    public function ajaxAction() {
        if($this->isAjax()) {
            $authors = $this->authors;
//            $authors = \R::getAll('SELECT * FROM authors WHERE author_id = ?', [$_POST['id']]);//, "author_id = {$_POST['id']}");
//            $authors = \R::getAll('SELECT * FROM authors ORDER BY author_surname');
            $this->loadView('ajax', compact('authors'));
            die;
        }
    }
}
