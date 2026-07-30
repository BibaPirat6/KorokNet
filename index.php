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
    <title>Корочки.Есть</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <?php if (!empty($_GET["msg"])): ?>
        <div class="message-box">
            <?php
            echo "<p>" . $_GET["msg"] . "</p>";
            ?>
        </div>
    <?php endif; ?>

    <!-- header -->
    <header class="header">
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

    <!-- banner -->
    <section class="banner">
        <div class="banner__box">
            <h1>Получи лучшее образование</h1>
            <p>Портал «Корочки.есть» представляет собой информационную систему для записи
                на онлайн курсы дополнительного профессионального образования</p>
            <a href="courses.php" class="btn_green">ВПЕРЕД!</a>
        </div>
        <div class="banner__arrow"><img src="assets/arrow_down.svg" alt="arrow_down"></div>
    </section>

    <!-- slider -->
    <section class="slider">
        <h2>Наши лаборатории</h2>
        <div class="slider__container">
            <img src="assets/slide1.jpg" alt="slide">
            <img src="assets/slide2.jpg" alt="slide">
            <img src="assets/slide3.jpg" alt="slide">
            <img src="assets/slide4.jpg" alt="slide">
        </div>
        <button href="/" class="about__arrow__left"><img src="assets/arrow_down.svg" alt="left"></button>
        <button href="/" class="about__arrow__right"><img src="assets/arrow_down.svg" alt="right"></button>
    </section>


    <!-- about -->
    <section class="about">
        <div class="about__box">
            <h2>Вкратце о нашей деятельности </h2>
            <p>Мы новая компания в сфере IT, продающая онлайн курсы. Все наши выпускники работают программистами и
                дизайнерами. Присоединяйся к нашей команде и лутай 300 миллионов рублей в наносекунду.</p>
            <a href="courses.php" class="btn_pink">Купить курс</a>
        </div>
    </section>


    <!-- adventages -->
    <section class="advantages">
        <h2>Почему мы, а не другие?</h2>
        <div class="advantages__list">
            <div class="advantages__item">
                <img src="assets/advantage1.png" alt="advantage">
                <p>Мы сотрудничаем с Яндекс и Google. Вас будут обучать лучшие. </p>
            </div>
            <div class="advantages__item">
                <img src="assets/advantage2.png" alt="advantage">
                <p>Современные методы обучения с помощью ИИ.</p>
            </div>
            <div class="advantages__item">
                <img src="assets/advantage3.png" alt="advantage">
                <p>Нас финансирует РФ и Казахстан.</p>
            </div>
        </div>
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


    <script src="scripts/slider.js"></script>
</body>

</html>