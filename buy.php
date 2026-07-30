<?php

session_start();
if (empty($_SESSION["user"]["id"])) {
    header("Location: ./auth.php?msg=Сначала войдите в аккаунт");
    die("Сначала надо войти в аккаунт");
}

if (empty($_GET["id"])) {
    header("Location: ./index.php?msg=Нужно сначала выбрать продукт");
    die("Нужен ид продукта");
}

if ($_SESSION["user"]["role"] === 2) {
    header("Location: ./index.php?msg=Админ не может подавать заявки");
    die("Админ не может подавать заявки");
}

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
    <title>Оформление заказа</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
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


    <!-- buy -->
    <section class="buy" id="buy-course">
        <form action="./php/server.php" class="form__buy" method="post">
            <h4>Формирование заявки</h4>

            <label for="buy_method">Способ оплаты</label>
            <select name="method" id="buy_method">
                <option value="1">Наличкой</option>
                <option value="2" selected>Картой</option>
            </select>
            <small class="error__input"></small>

            <label for="buy_date">Дата начала</label>
            <input required type="date" name="date" placeholder="Выберите дату" id="buy_date">
            <small class="error__input"></small>

            <input required type="number" name="course" value="<?= htmlspecialchars($_GET["id"]) ?>"
                style="display:none;">

            <input required type="text" name="form" value="buy" style="display:none;">

            <button class="btn_blue" type="submit">Оформить</button>
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
</body>

</html>