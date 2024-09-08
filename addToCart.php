<?php
session_start();
include 'db.php';
$product_id = $_POST['product_id'];
$amount = (int)$_POST['amount'];
$user_id = $_SESSION['user_id'];
if ($amount > 0)
{
    $stmt = $db->prepare("SELECT * FROM Cart WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute([':user_id' => $user_id, ':product_id' => $product_id]);
    $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($cart_item)
    {
        $stmt = $db->prepare("UPDATE Cart SET amount = amount + :amount WHERE id = :id");
        $stmt->execute([':amount' => $amount, ':id' => $cart_item['id']]);
    }
    else
    {
        $stmt = $db->prepare("INSERT INTO Cart (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute([':user_id' => $user_id, ':product_id' => $product_id, ':amount' => $amount]);
    }
}
header('Location: mainEntrAdminBD2.php');
exit();