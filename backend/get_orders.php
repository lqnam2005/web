<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "food_app");
$mysqli->set_charset("utf8");

// Nếu lỗi kết nối
if ($mysqli->connect_errno) {
    http_response_code(500);
    echo json_encode(["error" => "Kết nối thất bại: " . $mysqli->connect_error]);
    exit();
}

$sql = "
  SELECT id, customer_name, phone, address, status 
  FROM orders
  ORDER BY id DESC
";


$result = $mysqli->query($sql);

// Nếu lỗi truy vấn
if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Lỗi truy vấn: " . $mysqli->error]);
    exit();
}

// Trả dữ liệu
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);
?>
