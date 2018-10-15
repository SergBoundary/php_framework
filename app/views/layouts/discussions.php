<?php
    // Открытие сессии
    session_start();
?>
<!DOCTYPE html>
<html lang="<?=$language;?>">
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
        <link href="/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="/font-awesome/css/font-awesome.css" type="text/css" rel="stylesheet">
        <link href="/css/masonry.css" type="text/css" rel="stylesheet">

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            <div class="pull-right">
                <form action="" method="post" style="display: inline-block">
                    <a href="#" onclick="parentNode.submit();">de</a>
                    <input type="hidden" name="language" value="de"/>
                </form>&nbsp;&nbsp;
                <form action="" method="post" style="display: inline-block">
                    <a href="#" onclick="parentNode.submit();">en</a>
                    <input type="hidden" name="language" value="en"/>
                </form>&nbsp;&nbsp;
                <form action="" method="post" style="display: inline-block">
                    <a href="#" onclick="parentNode.submit();">fr</a>
                    <input type="hidden" name="language" value="fr"/>
                </form>&nbsp;&nbsp;
                <form action="" method="post" style="display: inline-block">
                    <a href="#" onclick="parentNode.submit();">it</a>
                    <input type="hidden" name="language" value="it"/>
                </form>&nbsp;&nbsp;
                <form action="" method="post" style="display: inline-block">
                    <a href="#" onclick="parentNode.submit();">pl</a>
                    <input type="hidden" name="language" value="pl"/>
                </form>&nbsp;&nbsp;
                <form action="" method="post" style="display: inline-block">
                    <a href="#" onclick="parentNode.submit();">ru</a>
                    <input type="hidden" name="language" value="ru"/>
                </form>&nbsp;&nbsp;
                <form action="" method="post" style="display: inline-block">
                    <a href="#" onclick="parentNode.submit();">sp</a>
                    <input type="hidden" name="language" value="sp"/>
                </form>&nbsp;&nbsp;
                <form action="" method="post" style="display: inline-block">
                    <a href="#" onclick="parentNode.submit();">ua</a>
                    <input type="hidden" name="language" value="ua"/>
                </form>&nbsp;
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="wrapper container">
                    <nav class="navbar navbar-inverse" role="navigation">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#level-navigation">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="http://framework.org" title="Главная страница"><span class="glyphicon glyphicon-tree-deciduous"></span></a>
                            </div>
                            <div class="collapse navbar-collapse" id="level-navigation">
                                <ul class="nav navbar-nav">
                                    <li><a href="/theories"><?=$interface['moduls'][1];?></a></li>
                                    <li><a href="/discussions"><?=$interface['moduls'][2];?></a></li>
                                    <li><a href="/projects"><?=$interface['moduls'][3];?></a></li>
                                    <li><a href="/management"><?=$interface['moduls'][4];?></a></li>
                                </ul>
                                <ul class="nav navbar-nav navbar-right">
                                    <li><a href="users" title="Вход"><span class="glyphicon glyphicon-user"></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <div class="heading">
                        <h3><?=$path;?></h3>
                    </div>
                    <nav class="navbar navbar-inverse" role="navigation">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu-navigation">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand active" href="http://framework.org" title="<?=$interface['directions'][0];?>"><span class="fa fa-newspaper-o"></span></a>
                            </div>
                            <div class="collapse navbar-collapse" id="menu-navigation">
                                <ul class="nav navbar-nav">
                                    <li class="active"><a href=""><?=$interface['directions'][1];?></a></li>
                                    <li><a href=""><?=$interface['directions'][2];?></a></li>
                                    <li><a href=""><?=$interface['directions'][3];?></a></li>
                                    <li><a href=""><?=$interface['directions'][4];?></a></li>
                                    <li><a href=""><?=$interface['directions'][5];?></a></li>
                                    <li><a href=""><?=$interface['directions'][6];?></a></li>
                                    <li><a href=""><?=$interface['directions'][7];?></a></li>
                                    <li><a href=""><?=$interface['directions'][8];?></a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <?= $content; ?>

                    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
                    <!-- Include all compiled plugins (below), or include individual files as needed -->
                    <script src="bootstrap/js/bootstrap.min.js"></script>
                    <?php 
                        foreach ($scripts as $script) {
                            echo $script;
                        }
                    ?>
                    <footer>
                      <div class="wrapper container">
                      <?php echo '&copy; 2002-'.date('Y').', Se Bo'; ?>
                      </div>
                    </footer>
                </div>
            </div>
        </div>
  </body>
</html>