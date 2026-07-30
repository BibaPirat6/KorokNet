<?php
session_start();
require_once "db.php";

$statusFilter = null;

if (!empty($_GET['status']) && preg_match('/^[0-9]+$/', $_GET['status'])) {
    $statusFilter = (int) $_GET['status'];
}

if ($statusFilter !== null) {
    $sql = "SELECT * FROM `requests` WHERE `status_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$statusFilter]);
} else {
    $sql = "SELECT * FROM `requests`";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$requests = [];

foreach ($result as $item) {
    // user
    $sql = "SELECT * from `users` where `id`=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$item["user_id"]]);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $login = $res[0]["login"];
    $fio = $res[0]["fio"];
    $phone = $res[0]["phone"];
    $email = $res[0]["email"];
    // course
    $sql = "SELECT * from `courses` where `id`=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$item["course_id"]]);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $course_title = $res[0]["title"];
    $course_price = $res[0]["price"];
    // method
    $sql = "SELECT * from `payment_method` where `id`=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$item["payment_method_id"]]);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $method = $res[0]["method"];
    $date_start = $item["date_start"];
    // status

    $sql = "SELECT * from `statuses` where `id`=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$item["status_id"]]);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $status = $res[0]["status"];

    $request = [
        "id" => $item["id"],
        "login" => $login,
        "fio" => $fio,
        "phone" => $phone,
        "email" => $email,
        "course_title" => $course_title,
        "course_price" => $course_price,
        "method" => $method,
        "date_start" => $date_start,
        "status" => $status,
        "review" => $item["review"],
        "date_review" => $item["date_review"]
    ];

    array_push($requests, $request);
}

