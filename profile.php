<?php
session_start();
if (empty($_SESSION["user"]["id"])) {
    header("Location: ./auth.php?msg=Сначала войдите в аккаунт");
    die("Сначала надо войти в аккаунт");
}


$login = htmlspecialchars($_SESSION["user"]["login"]) ?? "";
if (mb_strlen($login) > 10) {
    $login = mb_substr($login, 0, 10) . "...";
}

$fio = htmlspecialchars($_SESSION["user"]["fio"]) ?? "";
if (mb_strlen($fio) > 15) {
    $fio = mb_substr($fio, 0, 15) . "...";
}

$email = htmlspecialchars($_SESSION["user"]["email"]) ?? "";
if (mb_strlen($email) > 20) {
    $email = mb_substr($email, 0, 20) . "...";
}

$phone = htmlspecialchars($_SESSION["user"]["phone"]) ?? "";
if (mb_strlen($phone) > 11) {
    $phone = mb_substr($phone, 0, 11) . "...";
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <?php if (!empty($_SESSION["success-auth"])): ?>
        <div class="message-box success">
            <?php
            echo "<p>" . $_SESSION["success-auth"] . "</p>";
            unset($_SESSION["success-auth"]);
            ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION["success-review"])): ?>
        <div class="message-box success">
            <?php
            echo "<p>" . $_SESSION["success-review"] . "</p>";
            unset($_SESSION["success-review"]);
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

    <?php if ($_SESSION["user"]["role"] === 1): ?>
        <!-- user profile -->
        <section class="user__info">
            <div class="user__info__box">
                <div class="user__names">
                    <p title="<?= htmlspecialchars($_SESSION["user"]["fio"]) ?>"><span class="span_pink">ФИО</span> <span
                            class="span_blue"><?php echo htmlspecialchars($fio) ?></span>
                    </p>
                    <p title="<?= htmlspecialchars($_SESSION["user"]["login"]) ?>"><span class="span_pink">Логин</span>
                        <span class="span_blue"><?php echo htmlspecialchars($login) ?></span>
                    </p>
                </div>
                <div class="user__contacts">
                    <p title="<?= htmlspecialchars($_SESSION["user"]["email"]) ?>"><span class="span_pink">E-mail</span>
                        <span class="span_blue"><?php echo htmlspecialchars($email) ?></span>
                    </p>
                    <p title="<?= htmlspecialchars($_SESSION["user"]["phone"]) ?>"><span class="span_pink">Телефон</span>
                        <span class="span_blue">+<?php echo htmlspecialchars($phone) ?></span>
                    </p>
                </div>
            </div>
            <a href="./php/profile.php?action=logout" class="btn_blue">Выйти из профиля</a>
        </section>

        <section class="requests">
            <h2>Ваши заявки</h2>
            <div class="requests__list">
                <?php
                require_once "./php/requests.php";
                foreach ($requests as $item):
                    ?>
                    <div class="requests__item">
                        <div class="requests__header">
                            <h4><?php echo htmlspecialchars($item["title"]) ?></h4>
                            <p class="requests__price"><?php echo htmlspecialchars($item["price"]) ?> руб/мес</p>
                        </div>
                        <div class="requests__info">
                            <p class="requests__method">Оплата <?php
                            if ($item["method"] === "card") {
                                echo "по карте";
                            } elseif ($item["method"] === "money") {
                                echo "наличкой";
                            }
                            ?></p>
                            <p class="requests__date">Дата начала <?php echo htmlspecialchars($item["date"]) ?></p>
                            <div class="requests__status">
                                <?php
                                if ($item["status"] === "new") {
                                    echo "<p class='requests__status--new'>НОВОЕ</p>";
                                } elseif ($item["status"] === "learning") {
                                    echo "<p class='requests__status--learning'>ОБУЧЕНИЕ</p>";
                                } elseif ($item["status"] === "complete") {
                                    echo "<p class='requests__status--complete'>ЗАВЕРШЕН</p>";
                                }
                                ?>
                            </div>
                        </div>

                        <?php if ($item["status"] === "complete" && empty($item["review"])): ?>
                            <a href="review.php?request_id=<?= $item["id"] ?>" class="btn_pink">Отзыв</a>
                        <?php elseif (!empty($item["review"])): ?>
                            <p class="requests__status--learning">Вы уже ранее оставили отзыв о курсе</p>

                        <?php else: ?>
                            <p class="requests__status--learning">По завершении курса можно будет оставить отзыв</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>



        
    <?php elseif ($_SESSION["user"]["role"] === 2): ?>
        <!-- panel -->
        <section class="admin-panel">
            <h2>Здравствуйте админ!</h2>
            <div class="admin-panel__box">
                <div class="admin-panel__box__header">
                    <a href="admin-requests.php" class="btn_admin">Заявки</a>
                    <!-- <a href="admin-reviews.php" class="btn_admin">Отзывы</a> -->
                </div>
                <div class="admin-panel__box__footer">
                    <a href="./php/profile.php?action=logout" class="btn_logout">Выйти из аккаунта</a>
                </div>
            </div>
        </section>


    <?php endif; ?>




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