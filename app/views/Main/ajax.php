<?php 
//if($_POST['ajax_sql']) $variable = $_POST['ajax_sql'];
////echo $variable;
//switch ($variable) {
//    case 'author': {
////        echo 'author';
//        echo json_encode(array('1' => 'author 1', '2' => 'author 2'));
//        }
//        break;
//    case 'theme': {
////        echo 'theme';
//        echo json_encode(array('1' => 'theme 1', '2' => 'theme 2'));
//        }
//        break;
//    default:
//        break;
//}

//if($_POST['ajax_sql'] == 'authors') {
//    echo json_encode(array('1' => 'author 1', '2' => 'author 2'));
//} 

//if ($_POST['theme']) {
//    echo json_encode(array('1' => 'theme 1', '2' => 'theme 2'));
//} 
////else {
if($_POST['theories'] == 'authors') {
    if($_POST['list'] == 'new') {
        echo '<p>aurthors - new</p>';
        foreach ($authors['name'] as $key => $value) {
            if($authors['new'][$key] != false) echo '<p>'.$authors['name'][$key].' '.$authors['surname'][$key].'</p>';
        }
    } 
    if ($_POST['list'] == 'edited') {
        echo '<p>aurthors - edited</p>';
        foreach ($authors['name'] as $key => $value) {
            if($authors['edited'][$key] != false) echo '<p>'.$authors['name'][$key].' '.$authors['surname'][$key].'</p>';
        }
    } 
    if ($_POST['list'] == 'responses') {
        echo '<p>aurthors - responses</p>';
        foreach ($authors['name'] as $key => $value) {
            if($authors['response'][$key] != false) echo '<p>'.$authors['name'][$key].' '.$authors['surname'][$key].'</p>';
        }
    } 
//    foreach ($authors['name'] as $key => $value) {
//            echo '<p>'.$authors['name'][$key].' '.$authors['surname'][$key].'</p>';
//    }
} 
//elseif ($_POST['theories'] == 'themes') {
//    if($_POST['like'] == 'A') {
//        echo '<p>themes - A</p>';
//    } elseif ($_POST['like'] == 'B') {
//        echo '<p>themes - B</p>';
//    } 
//    foreach ($authors['name'] as $key => $value) {
//            echo '<p>'.$authors['surname'][$key].' '.$authors['name'][$key].'</p>';
//    }
//}

?>