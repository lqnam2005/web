<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "food_app");

if ($conn->connect_error) {
    echo json_encode(["name" => null, "error" => "DB connection failed"]);
    exit();
}

$sql = "SELECT name, SUM(quantity) as total FROM order_details GROUP BY name ORDER BY total DESC LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo json_encode(["name" => $row['name']]);
?>
