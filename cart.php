<?php
session_start();
include 'db.php';
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT Cart.*, Product.name, Product.price FROM Cart
                      JOIN Product ON Cart.product_id = Product.id
                      WHERE Cart.user_id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_sum = 0;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form method="post" action="updateCart.php">
    <?php foreach ($cart_items as $item): ?>
        <div>
            <p><?= $item['name'] ?> - $<?= $item['price'] ?></p>
            <label>Кількість: </label>
            <input type="number" name="amounts[<?= $item['id'] ?>]" value="<?= $item['amount'] ?>" min="1" required>
            <label>Купити: </label>
            <input type="checkbox" name="buy[<?= $item['id'] ?>]" <?= $item['buy'] ? 'checked' : '' ?>>
            <a href="removeFromCart.php?id=<?= $item['id'] ?>">Видалити</a>
        </div>
        <?php $total_sum += $item['price'] * $item['amount']; ?>
    <?php endforeach; ?>
    <p>Всього: $<?= $total_sum ?></p>
    <button type="submit">Оновити кошик</button>
</form>
</body>
</html>