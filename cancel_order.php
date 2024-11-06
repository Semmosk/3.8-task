<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Отмена заказа</title>
</head>
<body>
    <h1>Отменить заказ</h1>
    <form method="POST" action="cancel_order.php">
        <label for="order_number">Номер заказа:</label>
        <input type="text" name="order_number" required>
        <br>
        <label for="cancel_reason">Причина отмены:</label>
        <textarea name="cancel_reason" required></textarea>
        <br>
        <input type="submit" value="Отправить">
    </form>

    <?php
    $db_connection_string = 'mysql:host=localhost;dbname=shop';
    $db_user = 'root2';
    $db_pass = '123456789';

    try {
        $db_connection = new PDO($db_connection_string, $db_user, $db_pass);
        $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $order_number = $_POST['order_number'];
            $cancel_reason = $_POST['cancel_reason'];

            $sql = "INSERT INTO cancellations (order_id, reason) VALUES (:order_number, :cancel_reason)";
            $stmt = $db_connection->prepare($sql);
            $stmt->execute(['order_number' => $order_number, 'cancel_reason' => $cancel_reason]);
            echo "Заказ #$order_number успешно отменен!";
        }
    } catch (PDOException $e) {
        echo 'Ошибка подключения: ' . $e->getMessage();
    }
    ?>
</body>
</html>
