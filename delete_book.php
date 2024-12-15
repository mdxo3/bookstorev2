<?php
include 'database.php';

// Проверка дали има подаден параметър за ID на книгата
if (isset($_GET['id'])) {
    $bookId = (int)$_GET['id']; // Преобразуваме ID-то в число, за да избегнем SQL инжекции

    // Подготовка на SQL израз за изтриване на книгата
    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $bookId); // "i" означава integer

    if ($stmt->execute()) {
        // Ако изтриването е успешно, пренасочваме към index.php
        header("Location: index.php");
        exit(); // Излизаме от скрипта, за да не се изпълнява по-нататък код
    } else {
        // Ако има грешка при изтриването, показваме съобщение за грешка
        echo "Грешка при изтриването: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Ако няма подаден параметър ID, показваме съобщение за грешка
    echo "Няма подаден ID на книга за изтриване.";
}

$conn->close();
?>
