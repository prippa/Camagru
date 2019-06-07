<?php require VIEWS . 'includes/head_html.php' ?>

<div class="container">
    <h1>Регистрация</h1>

    <form action="https://echo.htmlacademy.ru" method="post">
        <label for="email-faild">Ваш логин (email):</label>
        <br>
        <input id="email-faild" type="text">
        <br>

        <label for="password-faild">Пароль:</label>
        <br>
        <input id="password-faild" type="password">
        <br>

        <label for="info-faild">Информация о себе:</label>
        <br>
        <textarea id="info-faild" rows="3"></textarea>
        <br>

        <input id="subscribe" type="checkbox" checked>
        <label for="subscribe">Подписаться на рассылку</label>
        <br>

        <input type="submit" value="Зарегистрироваться">
    </form>
</div>

<?php require VIEWS . 'includes/tail_html.php' ?>