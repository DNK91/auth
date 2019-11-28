<?php
session_id($_COOKIE['PHPSESSID']);
session_start();
setcookie('PHPSESSID', session_id(),  time()+3600*12);
$loadDataBase = simplexml_load_file('dataBase.xml');

// Выполнение logout
if(isset($_GET['user'])){
    if($_GET['user'] == 'logout'){
        session_destroy();
        unset($_COOKIE['PHPSESSID']);
        header('Location: template/login.php');
    }
}

/*
 * Получение и проверка POST запроса
 * по результату команда на выполнение регистрации, авторизации или проверки авторизации данного клиента
 *
 * */
if (isset($_POST['action']) && (!empty($_POST['action']))) {
    switch ($_POST['action']) {
        case 'register':
            registration($loadDataBase );
            break;
        case 'auth':
            auth($loadDataBase);
            break;
        case 'is-auth':
            isAuth($loadDataBase);
            break;
    }
}
// Проверка авторизации данного клиента
function isAuth($loadDataBase){
    foreach ($loadDataBase->users->user as $value) {
        if (($_SESSION['login'] == $value->login) && ($value->token == $_SESSION['token'] )) {
            return true;
        }
    }
    return false;
}
 /*
  * Выполнение авторизации
  * проверка на соответствие введённых данных с БД
  * отправка на вывод результата
  * установлением куки и сессии
  */
function auth($loadDataBase){
    $status = '';
    if (isset($_POST['login']) && isset($_POST['password'])) {
        if (empty($_POST['login']) || empty($_POST['password'])) {
            $status = 'err_2';
        } else{
            $_POST['login'] = getClearStr($_POST['login']);
            $_POST['password'] = getClearStr($_POST['password']);
            foreach ($loadDataBase->users->user as $value){
                if (($value->login == $_POST['login']) && ($value->password == md5($_POST['password']))){
                    $token = uniqid();
                    $status = 'ok';
                    unset($value->token);
                    $value->addChild('token', $token);
                    $loadDataBase->saveXML('dataBase.xml');
                    $_SESSION['token'] = $token;
                    $_SESSION['login'] = $_POST['login'];
                    break;
                }
            }
        }
    }
    echo $status;
}

/*
 * Выполнение регистрации
 * проверка
 * запись в БД
 * отправка на вывод результата
 */
function registration($loadDataBase )
{
    $status = '';
    $isExist = false;
    $_POST['name'] = getClearStr($_POST['name']);
    $_POST['email'] = getClearStr($_POST['email']);
    $_POST['login'] = getClearStr($_POST['login']);
    $_POST['password'] = getClearStr($_POST['password']);
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['login']) && isset($_POST['password'])){
        if (empty($_POST['name']) && empty($_POST['email']) && empty($_POST['login']) && empty($_POST['password'])) {
            $status = 'err_2';
        } else {
            foreach ($loadDataBase->users->user as $value){
                if (($value->login == $_POST['login']) || ($value->email == $_POST['email'])){
                    $status = 'err_1';
                    $isExist = true;
                    break;
                }
            }
        }
    }
    if(!$isExist){
        $newUser_1 = $loadDataBase->users->addChild('user');
        $newUser_1->addChild('name', $_POST['name']);
        $newUser_1->addChild('email', $_POST['email']);
        $newUser_1->addChild('login', $_POST['login']);
        $newUser_1->addChild('password', md5($_POST['password']));
        $loadDataBase->saveXML('dataBase.xml');
        $status = 'ok';
    }
    echo $status;
}


function getClearStr($str){
    return htmlspecialchars(trim($str));
}