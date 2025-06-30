<?php
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

$conn = new mysqli("localhost", "root", "", "food_app");

if ($conn->connect_error) {
  echo json_encode(["status" => "error", "message" => "Kết nối thất bại"]);
  exit();
}

$phone = $data["phone"];
$password = $data["password"];

$result = $conn->query("SELECT * FROM users WHERE phone = '$phone' AND password = '$password'");

if ($result && $result->num_rows > 0) {
  $user = $result->fetch_assoc();
  echo json_encode([
    "status" => "success",
    "user" => [
      "name" => $user["name"],
      "phone" => $user["phone"],
      "address" => $user["address"]
    ]
  ]);
} else {
  echo json_encode(["status" => "fail"]);
}


$conn->close();
?>
