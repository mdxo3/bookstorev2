<?php
include 'database.php';

// Проверка дали е избран критерий за сортиране
$order = "title";  // по подразбиране сортиране по заглавие
$sort = "ASC";  // по подразбиране възходящ ред

if (isset($_GET['order'])) {
    $order = $_GET['order'];
}
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
}

// Извличане на всички книги от базата данни със сортиране
$sql = "SELECT * FROM books ORDER BY $order $sort";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Онлайн книжарница</title>
</head>
<body>
    <h1>Онлайн книжарница</h1>

    <h2>Налични книги</h2>

    <!-- Формуляр за сортиране -->
    <form action="index.php" method="GET">
        <label for="order">Сортиране по:</label>
        <select name="order">
            <option value="title" <?php if ($order == 'title') echo 'selected'; ?>>Заглавие</option>
            <option value="author" <?php if ($order == 'author') echo 'selected'; ?>>Автор</option>
            <option value="price" <?php if ($order == 'price') echo 'selected'; ?>>Цена</option>
        </select>
        <label for="sort">Ред:</label>
        <select name="sort">
            <option value="ASC" <?php if ($sort == 'ASC') echo 'selected'; ?>>Възходящ</option>
            <option value="DESC" <?php if ($sort == 'DESC') echo 'selected'; ?>>Низходящ</option>
        </select>
        <input type="submit" value="Сортиране">
    </form>

    <table border="1">
        <tr>
            <th>Заглавие</th>
            <th>Автор</th>
            <th>Цена</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["title"] . "</td>
                        <td>" . $row["author"] . "</td>
                        <td>" . $row["price"] . " лв</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Няма налични книги</td></tr>";
        }
        ?>
    </table>

    <?php $conn->close(); ?>
</body>
</html>
