<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "food_app");
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Không thể kết nối CSDL"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$phone = $conn->real_escape_string($data["phone"]);
$name = $conn->real_escape_string($data["name"]);
$address = $conn->real_escape_string($data["address"]);
$password = $conn->real_escape_string($data["password"]);  // Bạn có thể thay bằng password_hash nếu muốn bảo mật

// Kiểm tra trùng
$result = $conn->query("SELECT * FROM users WHERE phone = '$phone'");
if ($result->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Số điện thoại đã tồn tại"]);
    exit;
}

// Thêm người dùng mới
$sql = "INSERT INTO users (phone, name, address, password) VALUES ('$phone', '$name', '$address', '$password')";
if ($conn->query($sql)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Lỗi truy vấn: " . $conn->error]);
}
