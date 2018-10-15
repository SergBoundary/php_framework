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

namespace basis\core;

/**
 * Description of ErrorHandler
 *
 * @author Se Bo
 */
class ErrorHandler {
    
    public function __construct() {
        if (DEBUG) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }
        set_error_handler([$this, 'errorHandler']);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
    }
    
    public function errorHandler($errno, $errstr, $errfile, $errline) {
        $this->logErrors($errstr, $errfile, $errline);
        if(DEBUG || in_array($errno, [E_USER_ERROR, E_RECOVERABLE_ERROR])) {
            $this->displayError($errno, $errstr, $errfile, $errline);
        }
        return TRUE;
    }
    
    public function fatalErrorHandler() {
        $error = error_get_last();
        if (!empty($error) && $error['type'] & ( E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR )) {
            $this->logErrors($error['message'], $error['file'], $error['line']);
            ob_end_clean();
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
            ob_end_flush();
        }
    }
    
    public function exceptionHandler($e) {
        $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }
    
    protected function logErrors($message = '', $file = '', $line = '') {
        error_log("[".date('Y-m-d H:i:s')."] "
                . "Ошибка: {$message} |  "
                . "Файл: {$file} |  "
                . "Строка: {$line} \n"
                . "======================\n", 3, ROOT.'/tmp/errors.log');
    }
    
    protected function displayError ($errno, $errstr, $errfile, $errline, $response = 500) {
        http_response_code($response);
        if($response == 404 && !DEBUG) {
            require WWW.'/errors/404.php';
            die;
        }
        if (DEBUG) {
            require WWW.'/errors/development.php';
        } else {
            require WWW.'/errors/prodaction.php';
        }
        die;
    }
    
}
