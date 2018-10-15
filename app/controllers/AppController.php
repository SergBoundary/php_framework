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

use basis\core\base\Controller;

/**
 * Description of AppController
 *
 * @author Se Bo
 */
class AppController extends Controller {
    public $interface = [];
    public $authors;
    public $meta;
    
    public function __construct($route) {
        parent::__construct($route);
    }
    
    public function setInterface($language = 'ua') {
        $model = new \app\models\Main;
        // Маркер языка интерфейса
        $this->interface[0] = $language;
        // Список языков
        $this->interface['languages'] = "";
        $result_languages = $model->findBySql( 'SELECT * FROM languages ORDER BY language_id');
        foreach ($result_languages as $row_languages) {
            if($row_languages['language_symbol'] == $language){
                $this->interface['languages'] .= "<form action='' method='post' style='display: inline-block'>"
                        ."    <a href='#' onclick='parentNode.submit();'><strong>{$row_languages['language_symbol']}</strong></a>"
                        ."    <input type='hidden' name='language' value='{$row_languages['language_symbol']}'/>"
                        ."</form>&nbsp;&nbsp;";
            } else {
                $this->interface['languages'] .= "<form action='' method='post' style='display: inline-block'>"
                        ."    <a href='#' onclick='parentNode.submit();'>{$row_languages['language_symbol']}</a>"
                        ."    <input type='hidden' name='language' value='{$row_languages['language_symbol']}'/>"
                        ."</form>&nbsp;&nbsp;";
            }
//            $this->interface['languages'][$row_languages['language_id']] = $row_languages['language_symbol'];
//            $this->interface['languages'][0] = $row_languages['language_id'];
        }
        // Список модулей
        $result_moduls = $model->findBySql( 'SELECT * FROM moduls ORDER BY modul_id');
        foreach ($result_moduls as $row_moduls) {
            $this->interface['moduls'][$row_moduls['modul_id']] = $row_moduls['modul_'.$language];
            // Список меню модуля
            $result_module_menu = $model->findBySql( 'SELECT * FROM module_menu WHERE module_id = ? ORDER BY module_menu_nr', [$row_moduls['modul_id']]);
            if($result_module_menu){
                foreach ($result_module_menu as $row_module_menu) {
                    $this->interface['module_menu'][$row_moduls['modul_id']][$row_module_menu['module_menu_nr']] = $row_module_menu['module_menu_'.$language];
                }
            }
        }
        // Список категорий прокрутки
        $result_module_scroll = $model->findBySql( 'SELECT * FROM module_scroll ORDER BY module_scroll_id');
        foreach ($result_module_scroll as $row_module_scroll) {
            $this->interface['module_scroll'][$row_module_scroll['module_scroll_id']] = $row_module_scroll['module_scroll_'.$language];
        }
        // Список тематических направлений
        $result_directions = $model->findBySql( 'SELECT * FROM directions ORDER BY direction_id');
        foreach ($result_directions as $row_directions) {
            // substr(str_repeat("0-", $system_count[0]), 0, (strlen(str_repeat("0-", $system_count[0])) - 1))
            $this->interface['directions'][$row_directions['direction_id']] = $row_directions['direction_'.$language];
            $this->interface['directions_description'][$row_directions['direction_id']] = $row_directions['direction_description_'.$language];
        }
//        debug($this->interface);
    }
    
    public function setAuthors($language = 'ua') {
        $model = new \app\models\Main;
        // Маркер языка интерфейса
        $this->authors[0] = $language;
        // Список авторов
        $result_authors = $model->findBySql('SELECT * FROM authors ORDER BY author_surname_'.$language);
        foreach ($result_authors as $row_authors) {
            $this->authors['name'][$row_authors['author_id']] = $row_authors['author_name_'.$language];
            $this->authors['surname'][$row_authors['author_id']] = $row_authors['author_surname_'.$language];
            $this->authors['born'][$row_authors['author_id']] = $row_authors['author_born'];
            $this->authors['new'][$row_authors['author_id']] = $row_authors['author_new'];
            $this->authors['edited'][$row_authors['author_id']] = $row_authors['author_edited'];
            $this->authors['response'][$row_authors['author_id']] = $row_authors['author_response'];
//            $this->authors['date'][$row_authors['author_id']] = $row_authors['author_date'];
        }
    }

    public function setMeta($title = '', $author ='', $copyright = '', $description = '', $keywords = '') {
        $this->meta = "<title>{$title}</title>"
                . "<meta name='author' content='{$author}' />"
                . "<meta name='copyright' content='&copy; {$copyright}' />"
                . "<meta name='description' content='{$description}'>"
                . "<meta name='keywords' content='{$keywords}'>";
    }
    
}
