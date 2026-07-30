<?php
require_once "db.php";
session_start();

if ($_POST["form"] === "register") {
    $_SESSION["errors"] = [];

    $email = htmlspecialchars(trim($_POST["email"]));
    $login = htmlspecialchars(trim($_POST["login"]));
    $fio = htmlspecialchars(trim($_POST["fio"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $pwd = htmlspecialchars(trim($_POST["pwd"]));

    $_SESSION["old"] = [
        "email" => $email,
        "login" => $login,
        "fio" => $fio,
        "phone" => $phone,
        "pwd" => $pwd,
    ];


    if (empty($email) || empty($login) || empty($fio) || empty($phone) || empty($pwd)) {
        $_SESSION["errors"]["empty"] = "Поля не должны быть пустыми";
    }
    if (!preg_match("/^\S+@\S+\.\S+$/", $email)) {
        $_SESSION["errors"]["email"] = "почта должна быть от 5 до 255 символов в формате example@gmail.com";
    }
    if (!preg_match("/^[A-Za-z0-9]{6,255}$/i", $login)) {
        $_SESSION["errors"]["login"] = "длина логина от 6 до 255, только английские и цифры";
    }
    if (!preg_match("/^[А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+$/ui", $fio)) {
        $_SESSION["errors"]["fio"] = "длина фио от 5 до 255 символов, только русские, пример иванов иван иванович";
    }
    if (!preg_match("/^\d{11,20}$/", $phone)) {
        $_SESSION["errors"]["phone"] = "телефон от 11 до 20 цифр";
    }
    if (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,255}$/i", $pwd)) {
        $_SESSION["errors"]["pwd"] = "длина пароля 8 - 255 символов, минимум 1 цифра, 1 заглавная, 1 символ, только английские";
    }

    $sql = "SELECT `login` from `users` where `login` = :login";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":login", $login);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION['errors']["unique-login"] = "Такой логин уже зарегистрирован";
    }

    if (!empty($_SESSION['errors'])) {
        header("Location: ../reg.php");
        exit;
    }


    $_SESSION["regdata"]["pwd"] = $pwd;

    $pwd = password_hash($pwd, PASSWORD_DEFAULT);

    $sql = "INSERT into `users` (`login`, `pwd`, `fio`, `phone`, `email`) values(?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($login, $pwd, $fio, $phone, $email));


    $_SESSION["success-reg"] = "Вы успешно зарегистрировались!";

    $_SESSION["regdata"]["login"] = $login;

    unset($_SESSION['old']);
    unset($_SESSION['errors']);
    header("Location: ../auth.php");
    exit;
}


if ($_POST["form"] === "auth") {
    $_SESSION["errors"] = [];

    $login = htmlspecialchars(trim($_POST["login"]));
    $pwd = htmlspecialchars(trim($_POST["pwd"]));

    $_SESSION["old"] = [
        "login" => $login,
        "pwd" => $pwd
    ];



    if (empty($login) || empty($pwd)) {
        $_SESSION["errors"]["empty"] = "Поля не должны быть пустыми";
    }
    if ($login !== "Admin") {
        if (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,255}$/i", $pwd)) {
            $_SESSION["errors"]["pwd"] = "длина пароля 8 - 255 символов, минимум 1 цифра, 1 заглавная, 1 символ, только английские";
        }
        if (!preg_match("/^[A-Za-z0-9]{6,255}$/i", $login)) {
            $_SESSION["errors"]["login"] = "длина логина от 6 до 255, только английские и цифры";
        }


        $sql = "SELECT * from `users` where `login` = :login";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":login", $login);
        $stmt->execute();
        $user = $stmt->fetchAll();

        if (!$user) {
            $_SESSION['errors']['auth'] = "Неверный логин или пароль";
        } elseif (!password_verify($pwd, $user[0]['pwd'])) {
            $_SESSION['errors']['auth'] = "Неверный логин или пароль";
        }

        if (!empty($_SESSION['errors'])) {
            header("Location: ../auth.php");
            exit;
        }
        $_SESSION["user"]["id"] = $user[0]["id"];
        $_SESSION["user"]["role"] = 1;
        $_SESSION["user"]["login"] = $user[0]["login"];
        $_SESSION["user"]["fio"] = $user[0]["fio"];
        $_SESSION["user"]["email"] = $user[0]["email"];
        $_SESSION["user"]["phone"] = $user[0]["phone"];

        $_SESSION["success-auth"] = "Вы успешно вошли в аккаунт";

        unset($_SESSION['regdata']);
        unset($_SESSION['old']);
        unset($_SESSION['errors']);
        header("Location: ../profile.php");
        exit;
    }


    if ($login === "Admin" && $pwd === "KorokNET") {
        $sql = "SELECT * from `users` where `login` = :login";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":login", $login);
        $stmt->execute();
        $user = $stmt->fetchAll();

        $_SESSION["user"]["id"] = $user[0]["id"];
        $_SESSION["user"]["role"] = 2;
        $_SESSION["user"]["login"] = $user[0]["login"];
        $_SESSION["user"]["fio"] = $user[0]["fio"];
        $_SESSION["user"]["email"] = $user[0]["email"];
        $_SESSION["user"]["phone"] = $user[0]["phone"];

        $_SESSION["success-auth"] = "Вы успешно вошли в аккаунт";

        unset($_SESSION['regdata']);
        unset($_SESSION['old']);
        unset($_SESSION['errors']);
        header("Location: ../profile.php");
        exit;
    } else {
        header("Location: ../auth.php");
        exit;
    }
}


if ($_POST["form"] === "buy") {
    $_SESSION["errors"] = [];

    $now = date("Y-m-d");

    $method = htmlspecialchars(trim($_POST["method"]));
    $date = htmlspecialchars(trim($_POST["date"]));
    $course = htmlspecialchars(trim($_POST["course"]));


    $_SESSION["old"] = [
        "course" => $course
    ];




    if (empty($method) || empty($date) || empty($course)) {
        $_SESSION["errors"]["empty"] = "Поля не должны быть пустыми";
    }
    if (!preg_match("/^(1|2|3)$/", $course)) {
        $_SESSION["errors"]["course"] = "Подделка id курса";
    }
    if (!preg_match("/^(1|2)$/", $method)) {
        $_SESSION["errors"]["method"] = "Подделка метода покупки";
    }

    if ($_POST["date"] < $now || $_POST["date"] > "2026-01-01") {
        $_SESSION["errors"]["date"] = "Указана неверная дата";
    }


    if (!empty($_SESSION['errors'])) {
        header("Location: ../buy.php?id=" . $course);
        exit;
    }


    $sql = "INSERT into `requests` (`user_id`, `course_id`, `payment_method_id`, `date_start`) values(?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($_SESSION["user"]["id"], $course, $method, $date));


    $_SESSION["success-buy"] = "Вы записались на курс";
    unset($_SESSION['old']);
    unset($_SESSION['errors']);
    header("Location: ../courses.php");
    exit;


}


if ($_POST["form"] == "review") {
    $_SESSION["errors"] = [];

    $msg = htmlspecialchars(trim($_POST["msg"]));
    $request_id = htmlspecialchars(trim($_POST["request_id"]));

    $_SESSION["old"] = [
        "msg" => $msg
    ];

    if (empty($msg)) {
        $_SESSION["errors"]["empty"] = "Поле не должно быть пустыми";
    }
    if (!preg_match("/^[\p{L}\p{N}\p{P}\p{S}\s]{10,500}$/u", $msg)) {
        $_SESSION["errors"]["msg"] = "Комментарий написан неправильно";
    }

    if (!empty($_SESSION['errors'])) {
        header("Location: ../review.php?request_id=" . $request_id);
        exit;
    }

    $date = date("Y-m-d");

    $sql = "UPDATE `requests`
        SET `review` = ?, `date_review` = ?
        WHERE `id` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$msg, $date, $request_id]);


    $_SESSION["success-review"] = "Вы оставили отзыв о курсе";
    unset($_SESSION['old']);
    unset($_SESSION['errors']);
    header("Location: ../profile.php");
    exit;
}


if ($_POST["form"] === "changeStatus") {
    $_SESSION["errors"] = [];

    $status = htmlspecialchars(trim($_POST["status"]));
    $request_id = htmlspecialchars(trim($_POST["request"]));

    if (empty($status) || empty($request_id)) {
        $_SESSION["errors"]["empty"] = "Поля не должны быть пустыми";
    }
    if (!preg_match("/^(5|6|7)$/", $status)) {
        $_SESSION["errors"]["status"] = "Неверный статус";
    }
    if (!empty($_SESSION['errors'])) {
        header("Location: ../admin-requests.php");
        exit;
    }

    $sql = "UPDATE `requests` SET `status_id` = ? WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$status, $request_id]);

    $_SESSION["success-change-status"] = "Вы изменили статус заявки";
    unset($_SESSION['errors']);
    header("Location: ../admin-requests.php");
    exit;
}