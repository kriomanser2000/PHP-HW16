<?php
session_start();
include 'db.php';
$user_id = $_SESSION['user_id'];
foreach ($_POST['amounts'] as $cart_id => $amount)
{
    $buy = isset($_POST['buy'][$cart_id]) ? 1 : 0;
    if ($amount > 0)
    {
        $stmt = $db->prepare("UPDATE Cart SET amount = :amount, buy = :buy WHERE id = :id AND user_id = :user_id");
        $stmt->execute([':amount' => $amount, ':buy' => $buy, ':id' => $cart_id, ':user_id' => $user_id]);
    }
}
header('Location: cart.php');
exit();