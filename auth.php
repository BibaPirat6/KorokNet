<?php
session_start();
if (!empty($_SESSION["user"]["login"])) {
    $login = htmlspecialchars($_SESSION["user"]["login"]) ?? "";
    if (mb_strlen($login) > 10) {
        $login = mb_substr($login, 0, 10) . "...";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <?php if (!empty($_SESSION["success-reg"])): ?>
        <div class="message-box success">
            <?php
            echo "<p>" . $_SESSION["success-reg"] . "</p>";
            unset($_SESSION["success-reg"]);
            ?>
        </div>
    <?php endif; ?>


    <?php if (!empty($_SESSION["errors"])): ?>
        <div class="message-box">
            <?php
            foreach ($_SESSION["errors"] as $err) {
                echo "<p>$err</p>";
            }
            unset($_SESSION["errors"]);
            ?>
        </div>
    <?php endif; ?>


    <?php if (!empty($_GET["msg"])): ?>
        <div class="message-box">
            <?php
            echo $_GET["msg"];
            ?>
        </div>
    <?php endif; ?>



    <!-- header -->
    <header class="header static">
        <a href="index.php" class="logo"><img src="assets/logo.svg" alt="logo"></a>
        <nav class="header__nav">
            <ul class="nav__menu">
                <li class="nav__item"><a href="courses.php" class="nav__link">Курсы</a></li>
                <li class="nav__item"><a href="reg.php" class="nav__link">Регистрация </a></li>
                <li class="nav__item"><a href="auth.php" class="nav__link">Авторизация</a></li>
                <?php if (!empty($_SESSION["user"]["id"])): ?>
                    <li title="<?= htmlspecialchars($_SESSION["user"]["login"]) ?>" class="nav__item"><a href="profile.php"
                            class="nav__link"><?php echo htmlspecialchars($login) ?></a>
                    </li>
                <?php else: ?>
                    <li class="nav__item"><a href="profile.php" class="nav__link">Профиль</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>


    <section class="auth" id="authorization">
        <form action="./php/server.php" class="form__auth" method="post">
            <h4>Авторизация</h4>
            <label for="auth_login">Логин</label>
            <input value="<?php echo $_SESSION["old"]["login"] ?? $_SESSION["regdata"]["login"] ?? "" ?>" type="text"
                name="login" placeholder="Введите логин" id="auth_login">
            <small id="auth_error_login" class="error__input"></small>

            <label for="auth_pwd">Пароль</label>
            <input value="<?php echo $_SESSION["old"]["pwd"] ?? $_SESSION["regdata"]["pwd"] ?? "" ?>" type="password"
                name="pwd" placeholder="Пароль" id="auth_pwd">
            <small id="auth_error_pwd" class="error__input"></small>

            <button class="btn_blue" type="submit">Авторизация</button>
            <a href="reg.php" class="reg__link">Нет аккаунта? Регистрация</a>

            <input type="text" style="display:none" value="auth" name="form">
        </form>
    </section>


    <!-- footer -->
    <footer class="footer">
        <div class="footer__menu">
            <div class="footer__item footer__nav">
                <h4>Разделы сайта</h4>
                <a href="courses.php">Курсы</a>
                <a href="reg.php">Регистрация</a>
                <a href="auth.php">Авторизация</a>
                <a href="profile.php">Профиль</a>
            </div>
            <div class="footer__item footer__contacts">
                <h4>Контакты</h4>
                <a href="mailto:korka@gmail.com">korka@gmail.com</a>
                <a href="tel:79998882233">+79998882233</a>
            </div>
            <div class="footer__item">
                <h4>О компании</h4>
                <p>Мы работает с 2021 года. В данный момент идут
                    скидки на все курсы -50%. Чтобы купить курс
                    сначала необходимо пройти регистрацию.</p>
            </div>
        </div>
        <div class="footer__copyright">@copyright Kostin 2025</div>
    </footer>

    <script src="scripts/validator.js"></script>
</body>

</html>