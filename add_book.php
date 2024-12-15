<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Вземане на стойностите от формата
    $title = htmlspecialchars($_POST['title']);
    $author = htmlspecialchars($_POST['author']);
    $price = $_POST['price'];

    // Валидация на цената да е число
    if (!is_numeric($price)) {
        echo "Цената трябва да е валидно число!";
        exit();
    }

    // Проверка за минимална дължина на заглавие и автор
    if (strlen($title) < 3 || strlen($author) < 3) {
        echo "Заглавието и авторът трябва да бъдат поне с 3 знака.";
        exit();
    }

    // Подготовка на SQL израз за вмъкване на данни
    $stmt = $conn->prepare("INSERT INTO books (title, author, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $title, $author, $price); // "ssd" означава: string, string, double

    if ($stmt->execute()) {
        echo "Книгата беше добавена успешно.";
    } else {
        echo "Грешка: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Пренасочване обратно към index.php
    header("Location: index.php");
    exit();
}
?>
