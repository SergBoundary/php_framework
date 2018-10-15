<!DOCTYPE html>
<html lang="<?=$language;?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Информация для поисковых роботов -->
        <meta name="robots" content="noindex, nofollow">
        <!-- Описание страницы -->
        <?=$meta;?>
        <!-- Логотип сайта -->
        <link type="image/png" rel="icon" href="img\logo.png" />
        <link type="image/x-icon" rel="shortcut icon" href="img\logo.png" />
        <!-- Bootstrap -->
        <link href="/bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet">
        <link href="/css/style.css" type="text/css" rel="stylesheet">
        <link href="/font-awesome/css/font-awesome.css" type="text/css" rel="stylesheet">
        <link href="/css/masonry.css" type="text/css" rel="stylesheet">

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
            var language = '<?php echo $interface[0]; ?>';
        </script>
    </head>
    <body>
        <div class="container">
            <div class="pull-right">
                <?=$interface['languages'];?>
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
                                <form name="sign-in" method="post" action="/user/signup" class="navbar-form navbar-right">
                                    <div class="form-group">
                                        <input name="login" type="text" class="form-control input-sm" placeholder="Login" value="">
                                    </div>
                                    <div class="form-group">
                                        <input name="password" type="password" class="form-control input-sm" placeholder="Password" value="">
                                    </div>
                                    <div class="form-group">
                                        <input name="email" type="email" class="form-control input-sm" placeholder="Email" value="">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Sign in</button>
                                </form>
                                <ul class="nav navbar-nav navbar-right">
                                    <li><a href="users" title="Вход"><span class="glyphicon glyphicon-user"></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <div class="heading">
                        <h4><?=$path;?></h4>
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
                                    <li class="active"><a href="news"><?=$interface['module_menu'][1][1];?></a></li>
                                    <li><a href="statistics"><?=$interface['module_menu'][1][2];?></a></li>
                                    <li><a href="dynamics"><?=$interface['module_menu'][1][3];?></a></li>
                                    <li><a href="relations"><?=$interface['module_menu'][1][4];?></a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <div class="well well-sm">
                        <div class="btn-toolbar" role="toolbar" style="margin: 0px 0px -2px 0px;">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="margin: -3px 0px 0px 0px; background-color: #aaa; color: #222;"><span id="menu-scroll"><?php echo $interface['module_scroll'][1].str_repeat("&nbsp;", (30 - strlen($interface['module_scroll'][1]))) ?></span> <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" id="times" onclick="return false"><?php echo $interface['module_scroll'][1].str_repeat("&nbsp;", 30 - strlen($interface['module_scroll'][1])) ?></a></li>
                                    <li><a href="#" id="themes" onclick="return false"><?php echo $interface['module_scroll'][2].str_repeat("&nbsp;", 30 - strlen($interface['module_scroll'][2])) ?></a></li>
                                    <li><a href="#" id="authors" onclick="return false"><?php echo $interface['module_scroll'][3].str_repeat("&nbsp;", 30 - strlen($interface['module_scroll'][3])) ?></a></li>
                                </ul>
                            </div>
                            <div class="btn-group"><?php $post; ?>&nbsp;&nbsp;
                            </div>
                            <div id="menu-scroll-times" class="btn-group" style="display: inline-block">
                                <a id="times-pre-year" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9668;</a>
                                <a id="times-pre-year-data" href="#" class="btn btn-default btn-sm"></a>
                                <a id="times-pre-month" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9668;</a>
                                <a id="times-pre-month-data" href="#" class="btn btn-default btn-sm"></a>
                                <a id="times-pre-day" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9668;</a>
                                <a id="times-pre-day-data-2" href="#" class="btn btn-default btn-sm"></a>
                                <a id="times-pre-day-data-1" href="#" class="btn btn-default btn-sm"></a>
                                <a href="#" class="btn btn-default" style="margin: -2px 0px 0px 0px; background-color: #aaa; color: #224;"><strong id="times-day-data-0"></strong></a>
                                <a id="times-post-day-data-1" href="#" class="btn btn-default btn-sm"></a>
                                <a id="times-post-day-data-2" href="#" class="btn btn-default btn-sm"></a>
                                <a id="times-post-day" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9658;</a>
                                <a id="times-post-month-data" href="#" class="btn btn-default btn-sm"></a>
                                <a id="times-post-month" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9658;</a>
                                <a id="times-post-year-data" href="#" class="btn btn-default btn-sm"></a>
                                <a id="times-post-year" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9658;</a>
                            </div>
                            <div id="menu-scroll-themes" class="btn-group" style="display: none">
                                <a id="themes-pre-letter" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9668;</a>
                                <a id="themes-pre-letter-data" href="#" class="btn btn-default btn-sm"></a>
                                <a id="themes-pre-syllable" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9668;</a>
                                <a id="themes-pre-syllable-data" href="#" class="btn btn-default btn-sm"></a>
                                <a id="themes-pre-title" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9668;</a>
                                <a id="themes-pre-title-data-1" href="#" class="btn btn-default btn-sm"></a>
                                <a href="#" class="btn btn-default" style="margin: -2px 0px 0px 0px; background-color: #aaa; color: #224;"><strong id="themes-title-data-0"></strong></a>
                                <a id="themes-post-title-data-1" href="#" class="btn btn-default btn-sm"></a>
                                <a id="themes-post-title" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9658;</a>
                                <a id="themes-post-syllable-data" href="#" class="btn btn-default btn-sm"></a>
                                <a id="themes-post-syllable" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9658;</a>
                                <a id="themes-post-letter-data" href="#" class="btn btn-default btn-sm"></a>
                                <a id="themes-post-letter" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9658;</a>
                            </div>
                            <div id="menu-scroll-authors" class="btn-group" style="display: none">
                                <a id="authors-pre-letter" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9668;</a>
                                <a id="authors-pre-letter-data" href="#" class="btn btn-default btn-sm"></a>
                                <a id="authors-pre-syllable" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9668;</a>
                                <a id="authors-pre-syllable-data" href="#" class="btn btn-default btn-sm"></a>
                                <a id="authors-pre-fullname" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9668;</a>
                                <a id="authors-pre-fullname-data-1" href="#" class="btn btn-default btn-sm"></a>
                                <a href="#" class="btn btn-default" style="margin: -2px 0px 0px 0px; background-color: #aaa; color: #224;"><strong id="authors-fullname-data-0"></strong></a>
                                <a id="authors-post-fullname-data-1" href="#" class="btn btn-default btn-sm"></a>
                                <a id="authors-post-fullname" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9658;</a>
                                <a id="authors-post-syllable-data" href="#" class="btn btn-default btn-sm"></a>
                                <a id="authors-post-syllable" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9658;</a>
                                <a id="authors-post-letter-data" href="#" class="btn btn-default btn-sm"></a>
                                <a id="authors-post-letter" href="#" class="btn btn-default btn-sm" style="background-color: #aaa; color: #222;">&#9658;</a>
                            </div>
                        </div>
                    </div>
                    <?= $content; ?>

                    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.js"></script>
                    <!-- Include all compiled plugins (below), or include individual files as needed -->
                    <script src="bootstrap/js/bootstrap.js"></script>
                    <script src="js/scroll.js"></script>
                    <script>
                        $(function(){
                            $('#times-day-data-0').click(function () {
                                $.ajax({
                                    url: '/main/ajax',
                                    type: 'post',
                                    data: {'theories': 'themes', 'like': 'B'},
                                    success: function (res) {
                                        $('#theories-panel').html(res);
//                                        console.log(res);
                                    },
                                    error: function () {
                                        alert('Error!');
                                    }
                                });
                            });
                        });
                    </script>
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