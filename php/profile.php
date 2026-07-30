<?php
session_start();
require_once "db.php";

if ($_GET["action"] === "logout" && !empty($_SESSION["user"]["id"])) {
    $_SESSION = [];
    unset($_SESSION);
    session_destroy();
    header("Location: ../auth.php?msg=Вы вышли из аккаунта");
    exit;
} else {
    header("Location: ../auth.php?msg=Сначала войдите в аккаунт");
    die("У вас нет аккаунта");
}

?>