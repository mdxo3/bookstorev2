<?php
session_start();
include 'database.php';

// Проверка дали потребителят е влязъл като администратор
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

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
    <title>Административен панел</title>
</head>
<body>
    <h1>Административен панел</h1>
    <a href="logout.php">Изход</a>

    <!-- Бутон за преминаване към клиентската страница -->
    <a href="index.php"><button>Отиди на клиентската страница</button></a>

    <h2>Добави нова книга</h2>
    <form action="add_book.php" method="POST">
        <label for="title">Заглавие:</label>
        <input type="text" name="title" required><br><br>
        <label for="author">Автор:</label>
        <input type="text" name="author" required><br><br>
        <label for="price">Цена:</label>
        <input type="text" name="price" required><br><br>
        <input type="submit" value="Добави книга">
    </form>

    <h2>Налични книги (Администраторски панел)</h2>

    <!-- Формуляр за сортиране -->
    <form action="admin.php" method="GET">
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
            <th>Действия</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["title"] . "</td>
                        <td>" . $row["author"] . "</td>
                        <td>" . $row["price"] . " лв</td>
                        <td><a href='admin.php?delete=" . $row["id"] . "'>Изтрий</a></td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Няма налични книги</td></tr>";
        }
        ?>
    </table>

    <?php $conn->close(); ?>
</body>
</html>
