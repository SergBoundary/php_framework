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

//use app\models\Theories;
use basis\core\App;
use basis\core\base\View;
use app\controllers\AppController;

/**
 * Description of LibaryController
 *
 * @author Se Bo
 */
class TheoriesController extends AppController {
    
    public $layout = 'theories';
    public $language;
    public $interface = [];
    public $directions = [];

    public function __construct($route) {
        parent::__construct($route);
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
        $language = $this->language;
        // Получение массива слов на выбранном пользователем языке
        $this->interface = App::$app->cache->get('interface');
        if(!$this->interface || $this->interface[0] != $this->language) {
            $this->setInterface($this->language);
            App::$app->cache->set('interface', $this->interface);
        }
    }
        
    public function newsAction() {
        $this->view = 'news';
        $language = $this->language;
        $interface = $this->interface;
        
        View::setMeta('Теории', 'Se Bo', date('Y').', Se Bo', 'Страница критического и библиотечного контента', 'мероприятия, критика, библиотека');
        $meta = $this->meta;
        $path = ucwords($this->layout).' / '.ucwords($this->view);
        $this->set(compact('language', 'interface', 'meta', 'path'));
    }
    
    public function viewAction() {
        $this->view = 'view';
    }
    
    public function workAction() {
        $this->view = 'work';
    }
    
    public function statisticsAction() {
        $this->view = 'statistics';
    }
    
}
