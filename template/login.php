<?php
require_once 'header.php';
?>

<h3>Авторизация</h3>
<form>
    <p><input type="text" name="login" id="login" placeholder="login" required/></p>
    <p><input type="text" name="password" id="password" placeholder="password" required/></p>
</form>
<button id="auth">Войти</button>
<a href="register.php">Зарегистрироваться</a>
<?php
require_once 'footer.php';
?>