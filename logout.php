<?php
session_start();
session_destroy();  // Изтрива сесията
header("Location: login.php");  // Пренасочва към login страницата
exit();
?>
