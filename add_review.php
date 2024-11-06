<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить отзыв</title>
</head>
<body>
    <h1>Добавить отзыв</h1>
    <form method="POST" action="add_review.php">
        <label for="user_name">Имя:</label>
        <input type="text" name="user_name" required>
        <br>
        <label for="user_review">Отзыв:</label>
        <textarea name="user_review" required></textarea>
        <br>
        <label for="user_rating">Рейтинг:</label>
        <input type="number" name="user_rating" min="1" max="5" required>
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
            $user_name = $_POST['user_name'];
            $user_review = $_POST['user_review'];
            $user_rating = (int) $_POST['user_rating'];

            $sql = "INSERT INTO reviews (name, review, rating) VALUES (:user_name, :user_review, :user_rating)";
            $stmt = $db_connection->prepare($sql);
            $stmt->execute(['user_name' => $user_name, 'user_review' => $user_review, 'user_rating' => $user_rating]);
            echo "Отзыв успешно добавлен!";
        }

        // Отображение отзывов
        $sql = "SELECT * FROM reviews";
        $stmt = $db_connection->query($sql);
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2>Отзывы:</h2>";
        foreach ($reviews as $review) {
            echo "<p><strong>{$review['name']}</strong>: {$review['review']} (Рейтинг: {$review['rating']})</p>";
        }
    } catch (PDOException $e) {
        echo 'Ошибка подключения: ' . $e->getMessage();
    }
    ?>
</body>
</html>
