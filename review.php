<?php
session_start();
if (empty($_SESSION["user"]["id"])) {
    header("Location: ./auth.php?msg=Сначала войдите в аккаунт");
    die("Сначала надо войти в аккаунт");
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
    <title>Отзыв о курсе</title>
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
    <section class="review" id="review">
        <div class="backbox">
            <img src="assets/arrow_left.svg" alt="arrow">
            <p><a href="profile.php">Назад в профиль</a></p>
        </div>

        <form action="./php/server.php" class="form__review" method="post">
            <h4>Отзыв о курсе</h4>

            <label for="review_msg">Комментарий</label>
            <textarea name="msg" id="review_msg" placeholder="Оставьте свой коммент о курсе"></textarea>
            <small id="review_error_msg" class="error__input"></small>


            <input type="number" name="request_id" value="<?= htmlspecialchars(trim($_GET["request_id"])); ?>"
                style="display:none;">

            <input type="text" name="form" value="review" style="display:none;">

            <button class="btn_blue" type="submit">ОТВЕТИТЬ</button>
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