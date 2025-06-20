<?php
header('Content-Type: application/json');
$mysqli = new mysqli("localhost", "root", "", "food_app");
$mysqli->set_charset("utf8");

// Lấy số người đăng ký hôm nay
$today = date("Y-m-d");
$result = $mysqli->query("SELECT COUNT(*) as count FROM users WHERE DATE(created_at) = '$today'");
$row = $result->fetch_assoc();
echo json_encode(["count" => (int)$row['count']]);
