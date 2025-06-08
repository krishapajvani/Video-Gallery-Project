<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!--	proper character encoding-->
    <meta charset="UTF-8">
<!--	responsive on mobile device-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Gallery</title>
<!--	favicon icon-->
		<link rel="icon" href="favi.png">
<!--bootstrap css effect-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<!--	jquery Library  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Animated Background */
        body {
            background: linear-gradient(-45deg, #ffee00, lavender, blueviolet, #001100);
            background-size: 400% 400%;
/*			change over 10s with gradient background*/
            animation: gradientBG 10s ease infinite;
            font-family: 'Arial', sans-serif;
            color: black;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Admin Button */
        .admin-btn {
            position: fixed;
            top: 15px;
            right: 15px;
            background: #000;
            color: #fff;
            padding: 10px 15px;
            border-radius: 50px;
/*            display: flex;*/
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: 0.3s;
        }
        .admin-btn:hover {
            background: #444;
        }
        .admin-btn i {
            font-size: 1.2em;
        }

        h2 {
            text-align: center;
            font-size: 2.5em;
            font-weight: bold;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
        }

        /* Search Bar */
        .input-group {
            max-width: 600px;
            margin: 20px auto;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .form-control {
            border-radius: 25px 0 0 25px;
        }
        .btn {
            border-radius: 0 25px 25px 0;
        }

        /* Video Container */
        .video-container {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3);
            opacity: 0;
            transform: scale(0.5) rotate(-5deg);
            animation: fadeInZoom 0.8s ease-in-out forwards;
        }

        /* Hover Effect */
        .video-container:hover {
            transform: scale(1.08) rotate(0deg);
            box-shadow: 0px 20px 40px rgba(255, 255, 255, 0.5);
        }

        /* YouTube Frame */
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 12px;
        }

        /* Fade In & Zoom Animation */
        @keyframes fadeInZoom {
            0% { opacity: 0; transform: scale(0.5) rotate(-5deg); }
            50% { opacity: 0.5; transform: scale(1) rotate(2deg); }
            100% { opacity: 1; transform: scale(1.02) rotate(0deg); }
        }

        /* Video Title */
        .video-title {
            margin-top: 15px;
            font-size: 1.2em;
            font-weight: bold;
            text-align: center;
            color: #fff;
           text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .video-container { margin-bottom: 20px; }
        }
    </style>
</head>
<body class="container mt-5">
    
    <!-- 🔧 Admin Button -->
    <a href="dashboard.php" class="admin-btn">
        <i>👩🏻‍💻</i> Admin
    </a>

    <h2>📽️ Video Gallery 📽️</h2>

    <!-- 🔍 Search Form -->
    <form id="search-form" class="mb-4">
        <div class="input-group">
            <input type="text" id="search" name="search" class="form-control" placeholder="Search videos...">
            <button type="submit" class="btn btn-dark">🧐</button>
        </div>
    </form>

    <div class="row" id="video-gallery">
        <!-- Videos will be loaded here via AJAX -->
    </div>

    <script>
//		only runs after the entire HTML document has been loaded.
        $(document).ready(function() {
//			This function fetches video data from the fetch_videos.php file.
            function fetchVideos(query = '') {
//				AJAX ($.ajax) sends an asynchronous request to fetch_videos.php.
                $.ajax({
                    url: 'fetch_videos.php',
//					/POST method is used to send data (search query).
                    method: 'POST',
//					When the request is successful, data (video HTML) is returned.
                    data: { search: query },
                    success: function(data) {
//						The received data (video list) is inserted into the #video-gallery div.
                        $('#video-gallery').html(data);
//						attachHoverEvents(); is called to add hover effects to newly loaded videos.
                        attachHoverEvents();
                    },
					//xhr.status : HTTP status code(404 not found, 500 server error)
					//status : error type(timeout,error,aboard,parse(invalid JSON))
					//error : specific error message in detail
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ', status, error);
                    }
                });
            }

            function attachHoverEvents() {
//				select all the video containner
                $('.video-container').hover(
//					hover in (mouse over)
                    function() {
//						get the video id stored in video container
                        let videoId = $(this).data('video-id');
//						find iframe inside video container
                        $(this).find('iframe').attr('src', 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&mute=1');
                    },
//					hover out(mouse leaves)
                    function() {
                        let videoId = $(this).data('video-id');
//						find video id and disable video control
                        $(this).find('iframe').attr('src', 'https://www.youtube.com/embed/' + videoId + '?controls=0');
                    }
                );
            }

            // Load videos
			//When the page loads, all videos are loaded by calling fetchVideos() without a search term.
            fetchVideos();

            // Handle search
			//#search-form : event listener on search form id=search-form
			//it triggers when clicked on enter or clicked on submit button
			//e : event object that happened just (form submision)
            $('#search-form').on('submit', function(e) {
				//prevent the browser from reloading the page
				//allow ajax to handle the search instead
				//smoother user experience
                e.preventDefault();
//				Retrieves the user's input from the search box (id="search").

//.val() gets the current value typed into the input field.
                let query = $('#search').val();
//				ajax will give request to fetch_video.php to return thevideo that matches the search
                fetchVideos(query);
            });
			//through 'input' every time the user insert for search or delete the live search will work 
			//real-time -search-filtering
            $('#search').on('input', function() {
				//.val() returns/get the value/data latest entered
				//$(this) refers to <input> feild itself
                let query = $(this).val();
				//call the video whenever the user type something
                fetchVideos(query);
            });
        });
    </script>

</body>
</html>
