<?php
include 'config.php';
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM videos WHERE id = ?");
$stmt->execute([$id]);
$video = $stmt->fetch();

if (!$video) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $url = $_POST['url'];
    $stmt = $conn->prepare("UPDATE videos SET title = ?, url = ? WHERE id = ?");
    $stmt->execute([$title, $url, $id]);
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Video</title>
		<link rel="icon" href="favi.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .edit-form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="edit-form-container">
        <h2 class="text-center mb-4">Edit Video</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="videoTitle" class="form-label">Title</label>
                <input type="text" id="videoTitle" name="title" value="<?php echo htmlspecialchars($video['title']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="videoUrl" class="form-label">YouTube URL</label>
                <input type="url" id="videoUrl" name="url" value="<?php echo htmlspecialchars($video['url']); ?>" class="form-control" required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Update Video</button>
                <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
