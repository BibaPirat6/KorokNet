<?php

session_start();
require_once "db.php";


$sql = "SELECT * from `requests` where `user_id`=:id";
$stmt = $conn->prepare($sql);
$stmt->bindValue(":id", $_SESSION["user"]["id"]);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


$requests = [];

foreach ($result as $item) {
    // course
    $sql = "SELECT * from `courses` where `id` = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":id", $item["course_id"]);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $title = $res[0]["title"];
    $price = $res[0]["price"];
    // method
    $sql = "SELECT * from `payment_method` where `id` = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":id", $item["payment_method_id"]);
    $stmt->execute();
    $method = $stmt->fetch();
    // status
    $sql = "SELECT * from `statuses` where `id` = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":id", $item["status_id"]);
    $stmt->execute();
    $status = $stmt->fetch();


    $request = [
        "id" => $item["id"],
        "title" => $title,
        "price" => $price,
        "method" => $method["method"],
        "date" => $item["date_start"],
        "status" => $status["status"],
        "review" => $item["review"]
    ];

    array_push($requests, $request);
}



?>