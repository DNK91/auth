<?php
require_once 'header.php';
?>

<h3>Регистрация</h3>
<form id="reg-form">
    <p><input type="text" name="name" id="name" placeholder="name" required/></p>
    <p><input type="email" name="email" id="email" placeholder="email" required/></p>
    <p><input type="text" name="login" id="login" placeholder="login" required/></p>
    <p><input type="text" name="password" id="password" placeholder="password" required/></p>
    <p><input type="text" name="confirm_password" id="confirm_password" placeholder="confirm_password" required/></p>
</form>
<button id="register">Зарегистрироваться</button>
<a href="login.php">Войти</a>
<?php
require_once 'footer.php';
?>
