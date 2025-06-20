<?php
header('Content-Type: application/json');

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "food_app");

if ($conn->connect_error) {
    echo json_encode(["count" => 0, "error" => "Kết nối CSDL thất bại"]);
    exit();
}

// ✅ Đếm tất cả đơn hàng (không phân biệt completed hay pending)
$sql = "SELECT COUNT(*) as count FROM orders";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Trả về kết quả dạng JSON
echo json_encode(["count" => $row['count']]);
?>
