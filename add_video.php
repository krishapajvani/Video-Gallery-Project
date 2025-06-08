<!--/* add_video.php - Adds a new video */-->
<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $url = $_POST['url'];
    $stmt = $conn->prepare("INSERT INTO videos (title, url) VALUES (?, ?)");
    $stmt->execute([$title, $url]);
    header("Location: dashboard.php");
    exit();
}
?>