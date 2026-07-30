<?php

session_start();
require_once "db.php";


$sql = "SELECT * from `courses`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);





?>