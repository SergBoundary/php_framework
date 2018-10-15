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
 * Description of Files
 *
 * @author Se Bo
 */
class Files {
    
    protected $types = [];
            


    public function __construct() {
        $types = require ROOT.'/config/config_fl.php';
        $this->types = $types;
    }
    
    public function getCount() {
        $file = [];
        $file_count = \R::getAll( 'SELECT file, count FROM file_count');
        foreach ($file_count as $key => $value) {
            $file[$value['file']] = $value['count'];
        }
        return $file;
    }
    
   
    public function getList() {
        $content = '';
        if($handle = opendir(FILES)) {
            $file_row = $this->getCount();
            $i = 0;
            while (false !== ($file = readdir($handle))) {
                if($file == "." || $file == "..") {
                    continue;
                }
                $str = "<a href='download?file={$file}' id='file_".$i."'>{$file}</a>";
                if(isset($file_row[$file])) {
                    $str .= " <spain id='file_count_".$i."'>({$file_row[$file]})</spain>";
                }
//                <div id="answer"></div>
                $str .= "<br />";
            $content .= $str;
            $i++;
            }
            closedir($handle);
            return $content;
        }
    }
    
    public function updateFile($file = '') {
        
        if(!in_array(substr($file, -3), $this->types)) {
            exit("Not type file '{$file}'.");
        }
        if(!is_file(FILES.$file)) {
            exit("Not exist file '{$file}'.");
        }
        
        if(!\R::getRow('SELECT file FROM file_count WHERE file = ?', [$file])) {
            \R::exec("INSERT INTO file_count (file, count) VALUES ('{$file}', '1')");
        } else {
            \R::exec("UPDATE file_count SET count=(count+1) WHERE file = '{$file}'");            
        }
        // Принудительная загрузка файла в папку "Загрузка" клиента 
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename(FILES.$file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize(FILES.$file));
        readfile(FILES.$file);
        // Передача и открытие файла PDF для чтения
//        header('Content-Type: application/pdf');
//        readfile(FILES.$file);
        exit();
    }
}
