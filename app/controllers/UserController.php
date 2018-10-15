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

use app\models\User;
use basis\core\base\View;

/**
 * Description of UserController
 *
 * @author Se Bo
 */
class UserController extends AppController {
    
    public function signupAction() {
        if(!empty($_POST)) {
            $user = new User();
            $data = $_POST;
            $user -> load($data);
            if ($user->validate($data)) {
                echo 'OK';
            } else {
                echo 'NO';
            }
            $mailer = new \PHPMailer\PHPMailer\PHPMailer();
            debug($mailer);
            die();
        }
    }
    
    public function loginAction() {
        try {
            //Server settings
            $mailer->SMTPDebug = 2;                                 // Enable verbose debug output
            $mailer->isSMTP();                                      // Set mailer to use SMTP
            $mailer->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
            $mailer->SMTPAuth = true;                               // Enable SMTP authentication
            $mailer->Username = 'user@example.com';                 // SMTP username
            $mailer->Password = 'secret';                           // SMTP password
            $mailer->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mailer->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mailer->setFrom('from@example.com', 'Mailer');
            $mailer->addAddress('joe@example.net', 'Joe User');     // Add a recipient
            $mailer->addAddress('ellen@example.com');               // Name is optional
            $mailer->addReplyTo('info@example.com', 'Information');
            $mailer->addCC('cc@example.com');
            $mailer->addBCC('bcc@example.com');

            //Attachments
            $mailer->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            $mailer->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mailer->isHTML(true);                                  // Set email format to HTML
            $mailer->Subject = 'Here is the subject';
            $mailer->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mailer->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mailer->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mailer->ErrorInfo;
        }
}
    
    public function logoutAction() {
        
    }
    
}
