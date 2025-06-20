<?php
$data = json_decode(file_get_contents("php://input"), true);
$mysqli = new mysqli("localhost", "root", "", "food_app");

$stmt = $mysqli->prepare("UPDATE orders SET status=? WHERE id=?");
$stmt->bind_param("si", $data['status'], $data['id']);
$stmt->execute();
