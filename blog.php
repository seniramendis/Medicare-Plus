<?php
$pageTitle = 'Health Blog & Tips';
$pageKey = 'blog'; // Not 'home'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Medicare Plus' : 'Health Blog - Medicare Plus'; ?></title>
    <link rel="icon" href="images/Favicon.png" type="image/png">

    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>

    <style>
        /* --- 1. GLOBAL BODY STYLES (Keep this here) --- */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f7f6;
            line-height: 1.6;
        }

        /* --- 2. PAGE-SPECIFIC STYLES (Blog) --- */
        .page-container {
            width: 85%;
            max-width: 900px;
            margin: 40px auto;
            padding: 30px 40px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(12, 12, 12, 0.08);
        }

        .service-detail h2 {
            font-size: 2.2em;
            color: #1e3a8a;
            margin-top: 0;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #57c95a;
        }

        .service-detail p {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 25px;
        }

        .button {
            display: inline-block;
            background-color: #57c95a;
            color: #fff;
            padding: 8px 20px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1em;
            border-radius: 30px;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .button:hover {
            background-color: #45a049;
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Blog List */
        .blog-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .blog-card {
            display: flex;
            flex-direction: column;
            background-color: #fdfdfd;
            border: 1px solid #e9e9e9;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
            /* Added overflow: hidden to contain the image */
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(30, 58, 138, 0.1);
        }

        .blog-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .blog-content {
            display: flex;
            flex-direction: column;
            padding: 25px;
            flex-grow: 1;
        }

        .blog-meta {
            font-size: 0.9em;
            color: #777;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .blog-meta span {
            color: #1e3a8a;
            font-weight: bold;
        }

        .blog-content h4 {
            font-size: 1.4em;
            color: #1e3a8a;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .blog-content p {
            font-size: 0.95em;
            color: #666;
            line-height: 1.5;
            flex-grow: 1;
            margin-bottom: 20px;
            margin-top: 0;
        }

        .blog-content a.button {
            margin-top: auto;
            align-self: flex-start;
        }

        /* --- Video List (NEW) --- */
        .video-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            /* 2 videos per row */
            gap: 25px;
            margin-top: 30px;
        }

        .video-card {
            display: flex;
            flex-direction: column;
            background-color: #fdfdfd;
            border: 1px solid #e9e9e9;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .video-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(30, 58, 138, 0.1);
        }

        /* Responsive iframe wrapper */
        .video-embed {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
        }

        .video-embed iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .video-content {
            padding: 20px;
        }

        .video-content h4 {
            font-size: 1.3em;
            color: #1e3a8a;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .video-content p {
            font-size: 0.95em;
            color: #666;
            line-height: 1.5;
            margin: 0;
        }

        /* --- 3. PAGE-SPECIFIC RESPONSIVE STYLES --- */
        @media screen and (max-width: 600px) {

            /* Page Specific Responsive */
            .page-container {
                width: 95%;
                padding: 20px 15px;
            }

            .blog-list {
                grid-template-columns: 1fr;
                /* This makes it a single column on mobile */
            }

            .video-list {
                grid-template-columns: 1fr;
                /* This makes videos single column on mobile */
            }
        }
    </style>
</head>

<body>

    <?php
    // HEADER GOES HERE, INSIDE THE BODY
    include 'header.php';
    ?>

    <main class="page-container">
        <div class="service-detail">
            <h2>Health Blog & Tips</h2>
            <p>Explore our latest articles on health, wellness, and medical advancements, written by the expert team at
                Medicare Plus.</p>
        </div>

        <div class="blog-list">
            <div class="blog-card">
                <img src="images/blog pic1.jpeg" alt="A bowl of healthy food">
                <div class="blog-content">
                    <div class="blog-meta">
                        <span>Nutrition</span> | Nov 11, 2025
                    </div>
                    <h4>The Top 5 Superfoods for Heart Health</h4>
                    <p>Discover five simple, nutrient-dense foods you can add to your diet...</p>
                    <a href="#" class="button">Read More</a>
                </div>
            </div>

            <div class="blog-card">
                <img src="https://images.pexels.com/photos/416809/pexels-photo-416809.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Person stretching at desk">
                <div class="blog-content">
                    <div class="blog-meta">
                        <span>Wellness</span> | Nov 10, 2025
                    </div>
                    <h4>Easy Stretches to Do at Your Desk</h4>

                    <p>Feeling stiff? Try these simple stretches to relieve tension...</p>
                    <a href="#" class="button">Read More</a>
                </div>
            </div>

            <div class="blog-card">
                <img src="https://images.pexels.com/photos/3771045/pexels-photo-3771045.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Person sleeping">
                <div class="blog-content">
                    <div class="blog-meta">
                        <span>Mental Health</span> | Nov 9, 2025
                    </div>
                    <h4>The Science of Sleep: Why It's So Important</h4>
                    <p>Learn why quality sleep is crucial for your physical and mental well-being.</p>
                    <a href="#" class="button">Read More</a>
                </div>
            </div>

            <div class="blog-card">
                <img src="https://images.pexels.com/photos/2182979/pexels-photo-2182979.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Doctor talking to patient">
                <div class="blog-content">
                    <div class="blog-meta">
                        <span>Patient Care</span> | Nov 8, 2025
                    </div>
                    <h4>Preparing for Your Hospital Visit</h4>
                    <p>A simple checklist to make your admission process smooth and stress-free.</p>
                    <a href="#" class="button">Read More</a>
                </div>
            </div>

            <div class="blog-card">
                <img src="https://images.pexels.com/photos/6776366/pexels-photo-6776366.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Child receiving a vaccine">
                <div class="blog-content">
                    <div class="blog-meta">
                        <span>Pediatrics</span> | Nov 7, 2025
                    </div>
                    <h4>Understanding Childhood Vaccinations</h4>
                    <p>Our pediatric expert answers common questions from parents.</p>
                    <a href="#" class="button">Read More</a>
                </div>
            </div>

            <div class="blog-card">
                <img src="https://images.pexels.com/photos/1127000/pexels-photo-1127000.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Person running outdoors">
                <div class="blog-content">
                    <div class="blog-meta">
                        <span>Fitness</span> | Nov 6, 2025
                    </div>
                    <h4>5 Benefits of Regular Cardiovascular Exercise</h4>

                    <p>It's not just about weight loss. See how cardio boosts your overall health.</p>
                    <a href="#" class="button">Read More</a>
                </div>
            </div>
        </div>

        <hr style="margin-top: 40px; margin-bottom: 30px; border: 1px solid #f0f0f0;">

        <div class="service-detail">
            <h2>Health Videos</h2>
            <p>Watch our health experts discuss important topics, share tips, and answer common questions.</p>
        </div>

        <div class="video-list">

            <div class="video-card">
                <div class="video-embed">
                    <iframe src="https://www.youtube.com/embed/gC_L9qAHVJ8" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="video-content">
                    <h4>Understanding Blood Pressure</h4>
                    <p>Dr. Perera explains what your blood pressure numbers mean.</p>
                </div>
            </div>

            <div class="video-card">
                <div class="video-embed">
                    <iframe src="https://www.youtube.com/embed/UYMmtEFhuxA" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="video-content">
                    <h4>5-Minute Stretches for Back Pain</h4>

                    <p>A quick, real-time guide from our physiotherapy department.</p>
                </div>
            </div>

        </div>

    </main>



    <?php
    include 'footer.php';
    ?>
</body>

</html>