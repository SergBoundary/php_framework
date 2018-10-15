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

namespace basis\libs;

/**
 * Description of Statistic
 *
 * @author Se Bo
 */
class Statistic {
    
    protected $language;
    protected $language_sql;
    protected $direction_sql;
    protected $status_sql;
    protected $type_sql;
    protected $category_sql;
    protected $author_sql;
    
    public function __construct($language) {
        $this->language = $language;
        // Условный параметр языка
        if (!empty($this->language)) {
            $language_sql = " AND cn.content_language = '".$language."'";
            $direction_sql = ", dr.direction_".$language; // CountUse, ListUse
            $status_sql = ", cs.content_status_".$language; // CountUse, ListUse
            $type_sql = ", ct.content_type_".$language; // CountUse, ListUse
            $category_sql = ", ct.content_category_".$language; // CountUse, ListUse
            $author_sql = ", ct.content_author_".$language; // CountUse, ListUse
        } else { // CountUse
            $direction_sql = ", dr.direction_de, dr.direction_en, dr.direction_fr, dr.direction_it, dr.direction_pl, dr.direction_ru, dr.direction_sp, dr.direction_ua";
            $status_sql = ", cs.content_status_de, cs.content_status_en, cs.content_status_fr, cs.content_status_it, cs.content_status_pl, cs.content_status_ru, cs.content_status_sp, cs.content_status_ua";
            $type_sql = ", ct.content_type_de, ct.content_type_en, ct.content_type_fr, ct.content_type_it, ct.content_type_pl, ct.content_type_ru, ct.content_type_sp, ct.content_type_ua";
            $category_sql = ", ct.content_category_de, ct.content_category_en, ct.content_category_fr, ct.content_category_it, ct.content_category_pl, ct.content_category_ru, ct.content_category_sp, ct.content_category_ua";
            $author_sql = ", ct.content_author_de, ct.content_author_en, ct.content_author_fr, ct.content_author_it, ct.content_author_pl, ct.content_author_ru, ct.content_author_sp, ct.content_author_ua";
        }
    }

    // Количество предлагаемых языков 
    function LanguagesCountAll ($db){
        $query = "SELECT Count(language_id) AS count
                  FROM languages";
        $result = \R::getRow($query);
        $count = $result['count'];
        return $count;
    }

    // Список предлагаемых языков 
    function LanguagesListAll ($db){
        $list_array = [];
        $query = "SELECT language_symbol, language_name, language_id
                  FROM languages
                  ORDER BY language_symbol";
        $result = \R::getAll($query);
        $i = 1;
        foreach( $result as $row ) {
            $list_array[0][$i] = $row['language_symbol'];
            $list_array[1][$i] = $row['language_name'];
            $list_array[2][$i] = $row['language_id'];
            $i++;
        }
        return $list_array;
    }
	
	// Количество используемых языков 
	function LanguagesCountUse ($db, $direction, $status, $type, $categor, $author){
            $query = "SELECT Count(t.language_id) AS count
                      FROM (SELECT ln.language_id
                      FROM languages AS ln, contents AS cn, 
                      content_relations_direction AS crd, 
                      content_relations_type AS crt,
                      content_relations_category AS crc,
                      content_relations_author AS cra
                      WHERE ln.language_symbol = cn.content_language 
                      AND cn.content_id = crd.content_id 
                      AND cn.content_id = crt.content_id
                      AND cn.content_id = crc.content_id
                      AND cn.content_id = cra.content_id
                      AND crd.direction_id = ".$direction." 
                      AND crt.content_type_id = ".$type."
                      AND crc.content_category_id = ".$category."
                      AND cra.author_id = ".$author."
                      GROUP BY ln.language_id) AS t";
            $result = \R::getRow($query);
            $count = $result['count'];
            return $count;
	}
	
	// Список используемых языков 
	function LanguagesListUse ($db, $direction, $status, $type, $category, $author){
		$query = "SELECT ln.language_symbol, ln.language_name
					FROM languages AS ln, contents AS cn, 
					content_relations_direction AS crd, 
					content_relations_type AS crt,
					content_relations_category AS crc,
					content_relations_author AS cra
					WHERE ln.language_symbol = cn.content_language 
					AND cn.content_id = crd.content_id 
					AND cn.content_id = crt.content_id
					AND cn.content_id = crc.content_id
					AND cn.content_id = cra.content_id
					AND crd.direction_id = ".$direction." 
					AND crt.content_type_id = ".$type."
					AND crc.content_category_id = ".$category."
					AND cra.author_id = ".$author."
					GROUP BY ln.language_symbol, ln.language_name
					ORDER BY ln.language_symbol";
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$list_array[0][$i] = $row[0];
			$list_array[1][$i] = $row[1];
			$i++;
		}
		return $list_array;
	}
	
	// Направления
	
	// Количество предлагаемых направлений 
	function DirectionsCountAll ($db, $language){
		$query = "SELECT Count(direction_id) AS count
					FROM directions
					WHERE direction_id <> 0";
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_array($result, MYSQLI_NUM);
			$count = $row[0] - 1;
		} else {
			die(mysqli_error($db));
		}
		return $count;
	}
	
	// Список предлагаемых направлений 
	function DirectionsListAll ($db, $language){
		if ($language != '') {
			$query = "SELECT direction_".$language."
						FROM directions
						WHERE direction_id <> 0
						ORDER BY direction_id";
		} else {
			$query = "SELECT direction_en
						FROM directions
						WHERE direction_id <> 0
						ORDER BY direction_id";
		}
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$list_array[$i] = $row[0];
			$i++;
		}
		return $list_array;
	}
	
	// Количество используемых направлений 
	function DirectionsCountUse ($db, $language, $type, $categor, $author){
			$query = "SELECT t.content_language, Count(t.direction_id) AS count 
						FROM (SELECT cn.content_language, dr.direction_id
						FROM directions AS dr, contents AS cn, 
						content_relations_direction AS crd, 
						content_relations_type AS crt,
						content_relations_category AS crc,
						content_relations_author AS cra
						WHERE dr.direction_id = crd.direction_id 
						AND cn.content_id = crd.content_id 
						AND cn.content_id = crt.content_id
						AND cn.content_id = crc.content_id
						AND cn.content_id = cra.content_id
						AND cn.content_language = '".$language."'
						AND crt.content_type_id = ".$type."
						AND crc.content_category_id = ".$category."
						AND cra.author_id = ".$author."
						GROUP BY cn.content_language, dr.direction_id
						ORDER BY cn.content_language) AS t
						GROUP BY t.content_language
						ORDER BY t.content_language";
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$list_array[0][$i] = $row[0];
			$list_array[1][$i] = $row[1];
			$i++;
		}
		return $list_array;
	}
	
	// Список используемых направлений 
	function DirectionsListUse ($db, $language, $type, $categor, $author){
		$query = "SELECT language_symbol, language_id
					FROM languages
					ORDER BY language_symbol";
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$language_use[0][$i] = $row[0];
			$language_use[1][$i] = $row[1];
			$i++;
		}
			$query = "SELECT cn.content_language, 
						dr.direction_".$language."
						FROM directions AS dr, contents AS cn, 
						content_relations_direction AS crd, 
						content_relations_type AS crt,
						content_relations_category AS crc,
						content_relations_author AS cra
						WHERE dr.direction_id = crd.direction_id 
						AND cn.content_id = crd.content_id 
						AND cn.content_id = crt.content_id
						AND cn.content_id = crc.content_id
						AND cn.content_id = cra.content_id
						AND cn.content_language = '".$language."'
						AND crt.content_type_id = ".$type."
						AND crc.content_category_id = ".$category."
						AND cra.author_id = ".$author."
						GROUP BY cn.content_language, 
						dr.direction_".$language."
						ORDER BY cn.content_language, 
						dr.direction_id";
			$language_bln = true;

			if ($language_bln === true) {
			$column = 1;
		} elseif ($language_bln === false) {
			$column = 2;
		}
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$list_array[0][$i] = $row[0];
			if ($language_bln == false) {
				// Если язык не указан, то ищем язык используемого направления 
				for ($j = 1; $j <= count($language_use[0]); $j++) {
					if ($row[0] == $language_use[0][$j]) {
						$column = $language_use[1][$j];
					}
				}
			}
			$list_array[1][$i] = $row[$column];
			$i++;
		}
		return $list_array;
	}
	
	// Типы

	// Количество предлагаемых типов 
	function TypesCountAll ($db, $language){
		$query = "SELECT Count(content_type_id) AS count
					FROM content_types";
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_array($result, MYSQLI_NUM);
			$count = $row[0];
		} else {
			die(mysqli_error($db));
		}
		return $count;
	}
	
	// Список предлагаемых типов 
	function TypesListAll ($db, $language){
		if ($language != '') {
			$query = "SELECT content_type_".$language."
						FROM content_types
						ORDER BY content_type_id";
		} else {
			$query = "SELECT content_type_en
						FROM content_types
						ORDER BY content_type_id";
		}
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$list_array[$i] = $row[0];
			$i++;
		}
		return $list_array;
	}
	
	// Количество используемых типов 
	function TypesCountUse ($db, $language, $direction, $category, $author){
			$query = "SELECT t.content_language, Count(t.content_type_id) AS count 
						FROM (SELECT cn.content_language, ct.content_type_id
						FROM content_types AS ct, contents AS cn, 
						content_relations_direction AS crd, 
						content_relations_type AS crt,
						content_relations_category AS crc,
						content_relations_author AS cra
						WHERE ct.content_type_id = crt.content_type_id 
						AND cn.content_id = crd.content_id
						AND cn.content_id = crt.content_id
						AND cn.content_id = crc.content_id
						AND cn.content_id = cra.content_id 
						AND cn.content_language = '".$language."'
						AND crd.direction_id = ".$direction."
						AND crc.content_category_id = ".$category."
						AND crt.content_author_id = ".$author."
						GROUP BY cn.content_language, ct.content_type_id
						ORDER BY cn.content_language) AS t
						GROUP BY t.content_language
						ORDER BY t.content_language";
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$list_array[0][$i] = $row[0];
			$list_array[1][$i] = $row[1];
			$i++;
		}
		return $list_array;
	}
	
	// Список используемых типов 
	function TypesListUse ($db, $language, $direction, $category, $author){
		$query = "SELECT language_symbol, language_id
					FROM languages
					ORDER BY language_symbol";
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$language_use[0][$i] = $row[0];
			$language_use[1][$i] = $row[1];
			$i++;
		}
			$query = "SELECT cn.content_language, 
						ct.content_type_".$language."
						FROM content_types AS ct, contents AS cn, 
						content_relations_direction AS crd, 
						content_relations_type AS crt,
						content_relations_category AS crc,
						content_relations_author AS cra
						WHERE ct.content_type_id = crt.content_type_id 
						AND cn.content_id = crd.content_id 
						AND cn.content_id = crt.content_id
						AND cn.content_id = crc.content_id
						AND cn.content_id = cra.content_id
						AND cn.content_language = '".$language."'
						AND crd.direction_id = ".$direction."
						AND crc.content_category_id = ".$category."
						AND cra.author_id = ".$author."
						GROUP BY cn.content_language, 
						ct.content_type_".$language."
						ORDER BY cn.content_language, 
						ct.content_type_id";
			$language_bln = true;
			$query = "SELECT cn.content_language, 
						ct.content_type_de, 
						ct.content_type_en, 
						ct.content_type_fr, 
						ct.content_type_it, 
						ct.content_type_pl, 
						ct.content_type_ru, 
						ct.content_type_sp, 
						ct.content_type_ua
						FROM content_types AS ct, contents AS cn, 
						content_relations_type AS crt
						WHERE ct.content_type_id = crt.content_type_id 
						AND cn.content_id = crt.content_id
						GROUP BY cn.content_language, 
						ct.content_type_de, 
						ct.content_type_en, 
						ct.content_type_fr, 
						ct.content_type_it, 
						ct.content_type_pl, 
						ct.content_type_ru, 
						ct.content_type_sp, 
						ct.content_type_ua
						ORDER BY cn.content_language, 
						ct.content_type_id";
			$language_bln = false;
		if ($language_bln === true) {
			$column = 1;
		} elseif ($language_bln === false) {
			$column = 2;
		}
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$list_array[0][$i] = $row[0];
			if ($language_bln == false) {
				// Если язык не указан, то ищем язык используемого типа 
				for ($j = 1; $j <= count($language_use[0]); $j++) {
					if ($row[0] == $language_use[0][$j]) {
						$column = $language_use[1][$j];
					}
				}
			}
			$list_array[1][$i] = $row[$column];
			$i++;
		}
		return $list_array;
	}
	
	// Категории
	
	// Подсчет количества категорий 
	function CategoriesCountAll ($db){
		$query = "SELECT Count(content_category_id) AS count
					FROM content_categories";
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_array($result, MYSQL_ASSOC);
			$count = $row['count'];
		} else {
			die(mysqli_error($db));
		}
		return $count;
	}
	
	// Список предлагаемых категорий 
	function CategoriesListAll ($db, $language){
		if ($language != '') {
			$query = "SELECT content_category_".$language."
						FROM content_categories
						ORDER BY content_category_id";
		} else {
			$query = "SELECT content_category_en
						FROM content_categories
						ORDER BY content_category_id";
		}
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$list_array[$i] = $row[0];
			$i++;
		}
		return $list_array;
	}
	
	// Количество используемых категорий 
	function CategoriesCountUse ($db, $language, $direction, $type, $author){
			$query = "SELECT t.content_language, Count(t.content_category_id) AS count 
						FROM (SELECT cn.content_language, cc.content_category_id
						FROM content_categories AS cc, contents AS cn, 
						content_relations_direction AS crd, 
						content_relations_type AS crt,
						content_relations_category AS crc,
						content_relations_author AS cra
						WHERE cc.content_category_id = crc.content_category_id 
						AND cn.content_id = crd.content_id
						AND cn.content_id = crt.content_id
						AND cn.content_id = crc.content_id
						AND cn.content_id = cra.content_id 
						AND cn.content_language = '".$language."'
						AND crd.direction_id = ".$direction."
						AND crt.content_type_id = ".$type."
						AND crc.content_author_id = ".$author."
						GROUP BY cn.content_language, cc.content_category_id
						ORDER BY cn.content_language) AS t
						GROUP BY t.content_language
						ORDER BY t.content_language";
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$list_array[0][$i] = $row[0];
			$list_array[1][$i] = $row[1];
			$i++;
		}
		return $list_array;
	}
	
	// Список используемых категорий 
	function CategoriesListUse ($db, $language, $direction, $category, $author){
		$query = "SELECT language_symbol, language_id
					FROM languages
					ORDER BY language_symbol";
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$language_use[0][$i] = $row[0];
			$language_use[1][$i] = $row[1];
			$i++;
		}
			$query = "SELECT cn.content_language, 
						cc.content_category_".$language."
						FROM content_categories AS cc, contents AS cn, 
						content_relations_direction AS crd, 
						content_relations_type AS crt,
						content_relations_category AS crc,
						content_relations_author AS cra
						WHERE cc.content_category_id = crc.content_category_id 
						AND cn.content_id = crd.content_id
						AND cn.content_id = crt.content_id
						AND cn.content_id = crc.content_id
						AND cn.content_id = cra.content_id 
						AND cn.content_language = '".$language."'
						AND crd.direction_id = ".$direction."
						AND crt.content_type_id = ".$type."
						AND crc.content_author_id = ".$author."
						GROUP BY cn.content_language, 
						cc.content_category_".$language."
						ORDER BY cn.content_language, 
							cc.content_category_id";
			$language_bln = true;
			$query = "SELECT cn.content_language, 
						cc.content_category_de, 
						cc.content_category_en, 
						cc.content_category_fr, 
						cc.content_category_it, 
						cc.content_category_pl, 
						cc.content_category_ru, 
						cc.content_category_sp, 
						cc.content_category_ua
						FROM content_categories AS cc, contents AS cn, 
						content_relations_category AS crc
						WHERE cc.content_category_id = crc.content_category_id 
						AND cn.content_id = crc.content_id
						GROUP BY cn.content_language, 
						cc.content_category_de, 
						cc.content_category_en, 
						cc.content_category_fr, 
						cc.content_category_it, 
						cc.content_category_pl, 
						cc.content_category_ru, 
						cc.content_category_sp, 
						cc.content_category_ua
						ORDER BY cn.content_language, 
						cc.content_category_id";
			$language_bln = false;
		if ($language_bln === true) {
			$column = 1;
		} elseif ($language_bln === false) {
			$column = 2;
		}
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$list_array[0][$i] = $row[0];
			if ($language_bln == false) {
				// Если язык не указан, то ищем язык используемой категории 
				for ($j = 1; $j <= count($language_use[0]); $j++) {
					if ($row[0] == $language_use[0][$j]) {
						$column = $language_use[1][$j];
					}
				}
			}
			$list_array[1][$i] = $row[$column];
			$i++;
		}
		return $list_array;
	}
	
	// Авторы
	
	// Количество используемых авторов 
	function AuthorsCountAll ($db, $language){
		$query = "SELECT Count(author_id) AS count
					FROM authors";
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_array($result, MYSQL_ASSOC);
			$count = $row['count'];
		} else {
			die(mysqli_error($db));
		}
		return $count;
	}
	
	// Список используемых авторов 
	function AuthorsListAll ($db, $language){
		if ($language != '') {
			$query = "SELECT content_author_surname_".$language.", 
						content_author_name_".$language."
						FROM content_authors
						ORDER BY content_author_surname_".$language.", 
						content_author_name_".$language."";
		} else {
			$query = "SELECT content_author_surname_en, 
						content_author_name_en
						FROM content_authors
						ORDER BY content_author_surname_en, 
						content_author_name_en";
		}
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$list_array[$i] = $row[0];
			$list_array[$i] = $row[1];
			$i++;
		}
		return $list_array;
	}
	
	// Количество используемых авторов 
	function AuthorsCountUse ($db, $language, $direction, $type, $category){
			$query = "SELECT t.content_language, Count(t.content_author_id) AS count 
						FROM (SELECT cn.content_language, ca.content_author_id
						FROM content_authors AS ca, contents AS cn, 
						content_relations_direction AS crd, 
						content_relations_type AS crt,
						content_relations_category AS crc,
						content_relations_author AS cra
						WHERE ca.content_author_id = cra.content_author_id 
						AND cn.content_id = crd.content_id
						AND cn.content_id = crt.content_id
						AND cn.content_id = crc.content_id
						AND cn.content_id = cra.content_id 
						AND cn.content_language = '".$language."'
						AND crd.direction_id = ".$direction."
						AND crt.content_type_id = ".$type."
						AND crc.content_category_id = ".$category."
						GROUP BY cn.content_language, ca.content_author_id
						ORDER BY cn.content_language) AS t
						GROUP BY t.content_language
						ORDER BY t.content_language";
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$list_array[0][$i] = $row[0];
			$list_array[1][$i] = $row[1];
			$i++;
		}
		return $list_array;
	}
	
	// Список используемых авторов 
	function AuthorsListUse ($db, $language, $direction, $type, $category){
		$query = "SELECT language_symbol, language_id
					FROM languages
					ORDER BY language_symbol";
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$language_use[0][$i] = $row[0];
			$language_use[1][$i] = $row[1];
			$i++;
		}
			$query = "SELECT cn.content_language, 
						ca.content_author_surname_".$language.", 
						ca.content_author_name_".$language."
						FROM content_authors AS ca, contents AS cn, 
						content_relations_direction AS crd, 
						content_relations_type AS crt,
						content_relations_category AS crc,
						content_relations_author AS cra
						WHERE ca.content_author_id = cra.content_author_id 
						AND cn.content_id = crd.content_id
						AND cn.content_id = crt.content_id
						AND cn.content_id = crc.content_id
						AND cn.content_id = cra.content_id 
						AND cn.content_language = '".$language."'
						AND crd.direction_id = ".$direction."
						AND crt.content_type_id = ".$type."
						AND crc.content_category_id = ".$category."
						GROUP BY cn.content_language, 
						ca.content_author_surname_".$language.", 
						ca.content_author_name_".$language."
						ORDER BY cn.content_language, 
						ca.content_author_surname_".$language.", 
						ca.content_author_name_".$language."";
			$language_bln = true;
			$query = "SELECT cn.content_language, 
						ca.content_author_surname_de, 
						ca.content_author_surname_en, 
						ca.content_author_surname_fr, 
						ca.content_author_surname_it, 
						ca.content_author_surname_pl, 
						ca.content_author_surname_ru, 
						ca.content_author_surname_sp, 
						ca.content_author_surname_ua, 
						ca.content_author_name_de, 
						ca.content_author_name_en, 
						ca.content_author_name_fr, 
						ca.content_author_name_it, 
						ca.content_author_name_pl, 
						ca.content_author_name_ru, 
						ca.content_author_name_sp, 
						ca.content_author_name_ua 
						FROM content_authors AS ca, contents AS cn, 
						content_relations_author AS cra
						WHERE ca.content_author_id = cra.content_author_id 
						AND cn.content_id = cra.content_id 
						GROUP BY cn.content_language, 
						ca.content_author_surname_".$language.", 
						ca.content_author_name_".$language."
						ORDER BY cn.content_language, 
						ca.content_author_surname_en, 
						ca.content_author_name_en";
			$language_bln = false;

		if ($language_bln === true) {
			$column = 1;
		} elseif ($language_bln === false) {
			$column = 2;
		}
		$result = mysqli_query($db, $query) or die(mysqli_error($db));
		// Если получен результат запроса
		$i = 1;
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$list_array[0][$i] = $row[0];
			if ($language_bln == false) {
				// Если язык не указан, то ищем язык используемого автора 
				for ($j = 1; $j <= count($language_use[0]); $j++) {
					if ($row[0] == $language_use[0][$j]) {
						$column = $language_use[1][$j];
					}
				}
			}
			$list_array[1][$i] = $row[$column];
			$i++;
		}
		return $list_array;
	}


}
