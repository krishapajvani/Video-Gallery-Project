<!--/* delete_video.php - Deletes a video */-->
<?php
include 'config.php';
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM videos WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}
header("Location: dashboard.php");
exit();
?>