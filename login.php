<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Потребителско име и парола за администратор
    if ($username == 'admin' && $password == 'Qwerty2023') {
        // Записваме информацията в сесията
        $_SESSION['loggedin'] = true;
        header("Location: admin.php");  // Пренасочване към административния панел
        exit();
    } else {
        $error = "Невалидно потребителско име или парола!";
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
</head>
<body>
    <h1>Административен вход</h1>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form action="login.php" method="POST">
        <label for="username">Потребителско име:</label>
        <input type="text" name="username" required><br><br>
        <label for="password">Парола:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Влез">
    </form>
</body>
</html>
