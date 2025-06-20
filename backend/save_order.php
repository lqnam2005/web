<?php
// Kết nối CSDL
$conn = new mysqli("localhost", "root", "", "food_app");
$conn->set_charset("utf8");

// Kiểm tra kết nối
if ($conn->connect_error) {
  die("Kết nối thất bại: " . $conn->connect_error);
}

// Nhận dữ liệu từ JavaScript gửi qua (POST)
$data = json_decode(file_get_contents("php://input"), true);


$name = $conn->real_escape_string($data['customer_name']);
$phone = $conn->real_escape_string($data['phone']);
$address = $conn->real_escape_string($data['address']);
$cart = $data['cart'];

// Thêm vào bảng orders
$conn->query("INSERT INTO orders (customer_name, phone, address) VALUES ('$name', '$phone', '$address')");
$order_id = $conn->insert_id;

// Thêm từng món vào bảng order_details
foreach ($cart as $item) {
  $item_name = $conn->real_escape_string($item['name']);
  $price = (int)$item['price'];
  $quantity = (int)$item['quantity'];
  $image = $conn->real_escape_string($item['image']);

  $conn->query("INSERT INTO order_details (order_id, name, price, quantity, image)
                VALUES ($order_id, '$item_name', $price, $quantity, '$image')");
}

echo json_encode(["status" => "success", "message" => "Đơn hàng đã được lưu"]);
$conn->close();
?>
