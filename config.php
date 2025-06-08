<?php
// Database credentials
$host = 'localhost';
$dbname = 'video_gallery';
$user = 'root';
$pass = '';


try {
    $conn = new PDO("mysql:host=localhost;dbname=video_gallery", "root", "");
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

