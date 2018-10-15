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
 * Description of Cache
 *
 * @author Se Bo
 */
class Cache {
    
    public function __construct() {
        
    }
    
    public function set($key, $data, $seconds = 3600) {
        $content['data'] = $data;
        $content['end_time'] = time() + $seconds;
        if(file_put_contents(CACHE.'/'. md5($key).'.txt', serialize($content))) {
            return true;
        }
        return false;
    }
    
    public function get($key) {
        $file = CACHE.'/'. md5($key).'.txt';
        if(file_exists($file)) {
            $content = unserialize(file_get_contents($file));
            if(time() <= $content['end_time']) {
                return $content['data'];
            }
            unlink($file);
        }
        return false;
    }
    
    public function delete($key) {
        $file = CACHE.'/'. md5($key).'.txt';
        if(file_exists($file)) {
            unlink($file);
        }
    }
    
}
