<?php
header('Content-Type: application/json');

$mysqli = new mysqli("localhost", "root", "", "food_app");
$mysqli->set_charset("utf8");

if ($mysqli->connect_errno) {
    http_response_code(500);
    echo json_encode(["error" => "Lỗi kết nối CSDL"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$name = $mysqli->real_escape_string($data["name"] ?? "");

if ($name === "") {
    http_response_code(400);
    echo json_encode(["error" => "Tên món ăn không hợp lệ"]);
    exit();
}

$result = $mysqli->query("DELETE FROM order_details WHERE name = '$name'");

if ($result) {
    echo json_encode(["success" => true]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Không thể xóa món ăn"]);
}
