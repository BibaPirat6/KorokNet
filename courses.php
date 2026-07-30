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
    <title>Список курсов</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <?php if (!empty($_SESSION["success-buy"])): ?>
        <div class="message-box success">
            <?php
            echo "<p>" . $_SESSION["success-buy"] . "</p>";
            unset($_SESSION["success-buy"]);
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


    <!-- courses -->
    <div class="courses">
        <h2>Курсы для айтишников</h2>
        <div class="courses__list">
            <?php
            require_once "./php/courses.php";
            foreach ($result as $key => $course):
                ?>
                <div class="courses__item">
                    <div class="courses__header">
                        <h3 class="courses__title"><?php echo htmlspecialchars($course["title"]) ?></h3>
                        <p class="courses__desc">В данный момент на курс действует скидка 50%</p>
                    </div>
                    <div class="courses__footer">
                        <p class="courses__price"><?php echo htmlspecialchars($course["price"]) ?> руб/мес</p>
                        <?php if (!empty($_SESSION["user"]["id"]) && $_SESSION["user"]["role"] !== 2): ?>
                            <a href="buy.php?id=<?= $course["id"] ?>" class="btn_pink">Купить</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>


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