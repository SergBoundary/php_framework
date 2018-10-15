<!DOCTYPE html>
<!--
Copyright (C) 2017 Se Bo

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Информация для поисковых роботов -->
        <meta name="robots" content="noindex, nofollow">
        <!-- Описание страницы -->
        <?php basis\core\base\View::getMeta() ?>
        <!-- Логотип сайта -->
        <link type="image/png" rel="icon" href="img\logo.png" />
        <link type="image/x-icon" rel="shortcut icon" href="img\logo.png" />
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="css\font-awesome.css">
        <link type="text/css" rel="stylesheet" href="css\masonry.css">

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <h1>Admin</h1>
        <p><?= $content ?></p>
    </body>
</html>