<?php
require_once('app.php');

//Проверка авторизации данного пользователя при входе на сайт
if(!isAuth($loadDataBase)){
    header('Location: ../template/login.php');
}
require_once 'template/header.php';
?>

Доброго времени суток Вам  <?= $_SESSION['login'] ?>
              <a href="app.php?user=logout">logout</a>
<?php
require_once 'template/footer.php';
?>

