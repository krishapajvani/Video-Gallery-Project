<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

// Fetch videos from the database
$stmt = $conn->query("SELECT * FROM videos ORDER BY created_at DESC");
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
	<link rel="icon" href="favi.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color:#9087DD;
        }
        .container {
            max-width: 800px;
            margin-top: 20px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .list-group-item:hover {
            background-color: #f1f1f1;
        }
        @media (max-width: 576px) {
            .btn-sm {
                font-size: 0.875rem;
                padding: 0.25rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card p-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                <h3 class="mb-3 mb-sm-0">Manage Videos</h3>
<div style="display: flex; gap: 15px; justify-content: center; align-items: center; margin-top: 20px;">
    <a href="login.php" class="btn btn-danger btn-sm px-4 py-2 shadow" style="border-radius: 25px; font-weight: bold; text-transform: uppercase; text-decoration: none;">
        Logout ↩
    </a>
    <a href="index.php" class="btn btn-primary btn-sm px-4 py-2 shadow" style="border-radius: 25px; font-weight: bold; text-transform: uppercase; text-decoration: none;">
        Video Gallery 🏚️
    </a>
</div>


                
            </div>
            <hr>
            <form action="add_video.php" method="POST" class="mb-3">
                <div class="mb-3">
                    <label for="title" class="form-label">Video Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter video title" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="url" class="form-label">YouTube URL</label>
                    <input type="url" id="url" name="url" placeholder="Enter YouTube URL" required class="form-control">
                </div>
                <button type="submit" class="btn btn-success w-100">Add Video</button>
            </form>
            <ul class="list-group">
                <?php foreach ($videos as $video): ?>
                    <li class="list-group-item d-flex flex-column flex-sm-row justify-content-between align-items-center">
                        <div class="text-center text-sm-start mb-2 mb-sm-0">
                            <strong><?php echo htmlspecialchars($video['title']); ?></strong> -
                            <a href="<?php echo htmlspecialchars($video['url']); ?>" target="_blank" class="text-primary">Watch</a>
                        </div>
                        <div class="d-flex">
                            <a href="edit_video.php?id=<?php echo $video['id'];?>" class="btn btn-warning btn-sm me-2">Edit</a>
                            <a href="delete_video.php?id=<?php echo $video['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>