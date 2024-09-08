<?php
session_start();
include 'db.php';
$cart_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("DELETE FROM Cart WHERE id = :id AND user_id = :user_id");
$stmt->execute([':id' => $cart_id, ':user_id' => $user_id]);
header('Location: cart.php');
exit();
