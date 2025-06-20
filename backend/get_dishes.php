<?php
header('Content-Type: application/json');

// Kết nối CSDL
$mysqli = new mysqli("localhost", "root", "", "food_app");
$mysqli->set_charset("utf8");

if ($mysqli->connect_errno) {
    http_response_code(500);
    echo json_encode(["error" => "Lỗi kết nối CSDL"]);
    exit();
}

// Lấy danh sách món ăn từ bảng order_details
$result = $mysqli->query("SELECT name, price, image FROM order_details");

$monan = [];
while ($row = $result->fetch_assoc()) {
    $monan[] = [
        "name" => $row["name"],
        "price" => (int)$row["price"],
        "image" => $row["image"]
    ];
}

echo json_encode($monan);
