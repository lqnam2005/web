<?php
$data = json_decode(file_get_contents("php://input"), true);
$mysqli = new mysqli("localhost", "root", "", "food_app");

$stmt1 = $mysqli->prepare("DELETE FROM order_details WHERE order_id=?");
$stmt1->bind_param("i", $data['id']);
$stmt1->execute();

$stmt2 = $mysqli->prepare("DELETE FROM orders WHERE id=?");
$stmt2->bind_param("i", $data['id']);
$stmt2->execute();
