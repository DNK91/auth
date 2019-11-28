/*
* Команда выполнение функций регистрации или авторизации после отправки формы
 */
$(function (){
    console.log('start');
    $('#register').click(function (){
        register();
    });
    $('#auth').click(function (){
        auth();
    });
});

/*
* Авторизация
 */
function auth() {
    let action = 'auth';
    let login = $('#login').val();
    let password = $('#password').val();
    $.ajax({
        url: '../app.php',
        type: 'POST',
        data: {login, password, action},
        success: function (data) {
            if (data === 'ok') window.location.replace('../index.php');
            if (data === 'err_2') alert('Ошибка авторизации! Заполните форму!');
            }
    });
}

/*
* Регистрация
 */
function register() {
    let action = 'register';
    let name = $('#name').val();
    let email = $('#email').val();
    let login = $('#login').val();
    let password = $('#password').val();
    let confirm_password = $('#confirm_password').val();

// Подтверждение введённого пароля
    if (password !== confirm_password){
        alert('Ошибка! Введённые Вами пароли отличаются. Попробуйте ещё раз!');
        return;
    };
    if ((password === '') || (confirm_password === '')){
        alert('Введите пароль и подтвердите его!');
        return;
    }
    /*
    *Отправка POST запроса в index.php для проверки и записи в БД
    *Вывод результата
     */
    $.ajax({
        url: '../app.php',
        type: 'POST',
        data: {name, email, login, password, action},
        success: function (data) {
            if (data === 'ok') {
                alert('Регистрация прошла успешно!');
                window.location.replace('../template/login.php');
            }
            if (data === 'err_1') {
                alert('Такой логин и/или почта  уже существует. Введите другие данные.');
            }
            if (data === 'err_2') {
                alert('Необходимо заполнить все поля');
            }
            console.log(data);
        }
    });
}



