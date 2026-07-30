<?php
session_start();

if (empty($_SESSION["user"]["id"])) {
    header("Location: ./auth.php?msg=Сначала войдите в аккаунт");
    die("Сначала надо войти в аккаунт");
}
if ($_SESSION["user"]["role"] === 1) {
    header("Location: ./index.php?msg=Эта страница для админов");
    die("Эта страница для админов");
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
    <title>Заявки пользователей</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <?php if (!empty($_SESSION["success-change-status"])): ?>
        <div class="message-box success">
            <?php
            echo "<p>" . $_SESSION["success-change-status"] . "</p>";
            unset($_SESSION["success-change-status"]);
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


    <section class="reviews-users">
        <div class="back-profile">
            <img src="assets/arrow_left.svg" alt="arrow">
            <p><a href="profile.php">Назад в профиль</a></p>
        </div>
        <div class="reviews-users__header">
            <h2>Заявки</h2>
            <div class="reviews__search">
                <input type="search" placeholder="Начать поиск">
            </div>
            <div class="reviews__filter">
                <a href="admin-filter.php?status=0" class="reviews__filter__item">Все</a>
                <a href="admin-filter.php?status=5" class="reviews__filter__item">Новая</a>
                <a href="admin-filter.php?status=6" class="reviews__filter__item">идет обучение</a>
                <a href="admin-filter.php?status=7" class="reviews__filter__item">обучение завершено</a>
            </div>
        </div>
        <div class="reviews-users__list">
            <?php
            require_once "./php/all-requests.php";
            foreach ($requests as $item):
                ?>
                <div class="reviews-users__list__item">
                    <div class="reviews-users__list__item-box">
                        <p title="<?= $item["fio"] ?>" class="limit" style="color: red;">ФИО
                            <?php echo htmlspecialchars($item["fio"]); ?>
                        </p>
                        <p title="<?= $item["login"] ?>" class="limit" style="color: orange;">ЛОГИН
                            <?php echo htmlspecialchars($item["login"]); ?>
                        </p>
                        <p title="<?= $item["email"] ?>" class="limit" style="color: yellow;">ПОЧТА
                            <?php echo htmlspecialchars($item["email"]); ?>
                        </p>
                        <p title="<?= $item["phone"] ?>" class="limit" style="color: green;">ТЕЛ.
                            +<?php echo htmlspecialchars($item["phone"]); ?></p>
                        <p title="<?= $item["course_title"] ?>" class="limit" style="color: sea;">КУРС
                            <?php echo htmlspecialchars($item["course_title"]); ?>
                        </p>
                        <p title="<?= $item["course_price"] ?>" class="limit" style="color: blue;">ЦЕНА
                            <?php echo htmlspecialchars($item["course_price"]); ?> руб/мес
                        </p>
                        <p title="<?= $item["method"] ?>" class="limit" style="color: purple;">ОПЛАТА <?php
                          if ($item["method"] === "card") {
                              echo "по карте";
                          } else if ($item["method"] === "money") {
                              echo "наличными";
                          }
                          ?></p>
                        <p title="<?= $item["date_start"] ?>" class="limit" style="color: pink;">СТАРТУЕТ
                            <?php echo htmlspecialchars($item["date_start"]); ?>
                        </p>
                        <p title="<?= $item["status"] ?>" class="limit">СТАТУС <?php
                          if ($item["status"] === "new") {
                              echo "НОВОЕ";
                          } else if ($item["status"] === "learning") {
                              echo "ОБУЧАЕТСЯ";
                          } else if ($item["status"] === "complete") {
                              echo "ЗАВЕРШЕНО";
                          }
                          ?></p>
                        <p title="<?= $item["review"] ?>" class="limit" style="color: pink;">Комментарий
                            <?php echo $item["review"] ?? "-" ?>
                        </p>
                        <p title="<?= $item["date_review"] ?>" class="limit" style="color: pink;">Опубликован
                            <?php echo $item["date_review"] ?? "-" ?>
                        </p>
                    </div>
                    <form action="./php/server.php" method="post" class="form-change">
                        <select required name="status">
                            <option value="5">Новая</option>
                            <option value="6">идет обучение</option>
                            <option value="7">обучение завершено</option>
                        </select>
                        <button type="submit" class="btn_pink">Изменить статус</button>

                        <input required type="number" name="request" value="<?= htmlspecialchars($item["id"]) ?>"
                            style="display:none;">

                        <input required type="text" name="form" value="changeStatus" style="display:none;">
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="reviews-users__pagination">
            <div class="reviews-users__pagination__item">Назад</div>
            <div class="reviews-users__pagination__item">1</div>
            <div class="reviews-users__pagination__item">2</div>
            <div class="reviews-users__pagination__item">3</div>
            <div class="reviews-users__pagination__item">Вперед</div>
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
</body>

</html>