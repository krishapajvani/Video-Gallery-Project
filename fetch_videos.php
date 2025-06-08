<?php
//database connection
include 'config.php';

// Function to extract YouTube Video ID from URL
function extractYouTubeID($url) {
	//pattern matching with regular expressions (regex). 
    if (preg_match('/(?:youtube\.com\/.*[?&]v=|youtu\.be\/|youtube\.com\/embed\/)([^?&\/]*)/', $url, $matches)) {
        return $matches[1];
    }
    return '';
}

// Check if a search query is entered
//isset : check if variable exist

$search = isset($_POST['search']) ? $_POST['search'] : '';

// Fetch videos based on search query
if ($search) {
    $stmt = $conn->prepare("SELECT * FROM videos WHERE title LIKE ? ORDER BY created_at DESC");
	//prepare statement
	//array containing a search string
    $stmt->execute(["%$search%"]);
} else {
	//fetch all record as per the time stamp in database(created_at)
    $stmt = $conn->query("SELECT * FROM videos ORDER BY created_at DESC");
}
$videos = $stmt->fetchAll();

if (count($videos) > 0):
    foreach ($videos as $video):
        $videoId = extractYouTubeID($video['url']);
?>
        <div class="col-md-4 mb-4">
            <div class="video-container" data-video-id="<?php echo $videoId; ?>">
                <iframe src="https://www.youtube.com/embed/<?php echo $videoId; ?>?controls=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
<!--			 htmlspecialchars : convert special HTML characters into their corresponding HTML entities-->
<!--			HTML entities : are special codes that replace reserved characters in HTML, so they display as text instead of being interpreted as code.-->
            <div class="video-title"><?php echo htmlspecialchars($video['title']); ?></div>
        </div>
<?php
    endforeach;
else:
?>
    <p class="text-center text-danger">No videos found.</p>
<?php
endif;
?>
