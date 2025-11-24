<?php
// --- LINE 1: START SESSION ---
ob_start();
session_start();

// --- 1. BLOG DATA "DATABASE" ---
$blogPosts = [
    1 => [
        'title' => 'The Top 5 Superfoods for Heart Health',
        'date' => 'Nov 11, 2025',
        'category' => 'Nutrition',
        'image' => 'images/blog pic1.jpeg',
        'content' => '
            <p>Heart disease remains one of the leading causes of health issues globally, but the good news is that your diet plays a massive role in prevention. Incorporating nutrient-dense superfoods can lower blood pressure, reduce cholesterol, and keep your heart beating strong.</p>
            <h3>1. Leafy Green Vegetables</h3>
            <p>Spinach, kale, and collard greens are well-known for their wealth of vitamins, minerals, and antioxidants. In particular, they’re a great source of vitamin K, which helps protect your arteries and promote proper blood clotting.</p>
            <h3>2. Berries</h3>
            <p>Strawberries, blueberries, blackberries, and raspberries are jam-packed with important nutrients that play a central role in heart health. Berries are also rich in antioxidants like anthocyanins, which protect against the oxidative stress and inflammation that contribute to the development of heart disease.</p>
            <h3>3. Avocados</h3>
            <p>Avocados are an excellent source of heart-healthy monounsaturated fats, which have been linked to reduced levels of cholesterol and a lower risk of heart disease.</p>
            <p><strong>Conclusion:</strong> Small changes make a big difference. Try adding just one of these foods to your plate every day!</p>'
    ],
    2 => [
        'title' => 'Easy Stretches to Do at Your Desk',
        'date' => 'Nov 10, 2025',
        'category' => 'Wellness',
        'image' => 'https://images.pexels.com/photos/416809/pexels-photo-416809.jpeg?auto=compress&cs=tinysrgb&w=600',
        'content' => '
            <p>Sitting for prolonged periods can lead to stiffness, back pain, and reduced circulation. If you work a 9-to-5 desk job, incorporating movement is non-negotiable for your long-term health.</p>
            <h3>The Neck Roll</h3>
            <p>Drop your chin to your chest and slowly roll your ear to your shoulder. Hold for 10 seconds. Repeat on the other side. This relieves tension headaches often caused by staring at screens.</p>
            <h3>The Seated Spinal Twist</h3>
            <p>Sit sideways in your chair. Twist your upper body towards the back of the chair, holding the backrest with both hands. This helps decompress the lower back.</p>
            <p>Remember to set a timer every hour to stand up and move!</p>'
    ],
    3 => [
        'title' => 'The Science of Sleep: Why It\'s So Important',
        'date' => 'Nov 9, 2025',
        'category' => 'Mental Health',
        'image' => 'https://images.pexels.com/photos/3771045/pexels-photo-3771045.jpeg?auto=compress&cs=tinysrgb&w=600',
        'content' => '
            <p>We spend about a third of our lives sleeping, yet many of us treat it as a luxury rather than a necessity. Science shows that sleep is the foundation of mental and physical health.</p>
            <h3>Memory Consolidation</h3>
            <p>While you sleep, your brain processes the day\'s information, moving short-term memories into long-term storage. Without adequate rest, learning becomes difficult.</p>
            <h3>Physical Repair</h3>
            <p>During deep sleep, your body releases hormones that repair cells and control the body\'s use of energy. This is also when the immune system strengthens itself against potential infections.</p>'
    ],
    4 => [
        'title' => 'Preparing for Your Hospital Visit',
        'date' => 'Nov 8, 2025',
        'category' => 'Patient Care',
        'image' => 'https://images.pexels.com/photos/2182979/pexels-photo-2182979.jpeg?auto=compress&cs=tinysrgb&w=600',
        'content' => '
            <p>Visiting the hospital, whether for a check-up or admission, can be stressful. A little preparation goes a long way in making the experience smoother.</p>
            <h3>Documents to Bring</h3>
            <ul>
                <li>National ID or Passport</li>
                <li>Insurance Cards/Forms</li>
                <li>A list of current medications and dosages</li>
                <li>Past medical records if transferring from another doctor</li>
            </ul>
            <h3>Personal Items</h3>
            <p>If you are staying overnight, bring comfortable loose clothing, toiletries, and perhaps a book or tablet to pass the time. Leave valuables at home.</p>'
    ],
    5 => [
        'title' => 'Understanding Childhood Vaccinations',
        'date' => 'Nov 7, 2025',
        'category' => 'Pediatrics',
        'image' => 'https://images.pexels.com/photos/6776366/pexels-photo-6776366.jpeg?auto=compress&cs=tinysrgb&w=600',
        'content' => '
            <p>Vaccines are one of the greatest success stories in public health. They have eradicated terrible diseases and protected millions of children.</p>
            <h3>How Do They Work?</h3>
            <p>Vaccines train your child\'s immune system to recognize and fight specific viruses or bacteria. They introduce a harmless piece of the germ, so if the child encounters the real thing later, their body is ready to fight it off immediately.</p>
            <h3>Common Concerns</h3>
            <p>It is normal for a child to have a mild fever or soreness at the injection site. These are signs that the immune system is building protection. Serious side effects are extremely rare.</p>'
    ],
    6 => [
        'title' => '5 Benefits of Regular Cardiovascular Exercise',
        'date' => 'Nov 6, 2025',
        'category' => 'Fitness',
        'image' => 'https://images.pexels.com/photos/1127000/pexels-photo-1127000.jpeg?auto=compress&cs=tinysrgb&w=600',
        'content' => '
            <p>Cardio isn\'t just about running marathons or losing weight. It is essential for keeping your body\'s engine—your heart—running smoothly.</p>
            <ol>
                <li><strong>Stronger Heart:</strong> Like any muscle, the heart gets stronger with exercise, pumping blood more efficiently.</li>
                <li><strong>Improved Mood:</strong> Cardio releases endorphins, the "feel-good" hormones that combat depression and anxiety.</li>
                <li><strong>Better Sleep:</strong> Regular exercise helps you fall asleep faster and deepens your sleep.</li>
                <li><strong>Increased Energy:</strong> It might seem counterintuitive, but spending energy on exercise actually increases your overall stamina.</li>
                <li><strong>Immune Boost:</strong> Regular, moderate exercise helps flush bacteria out of the lungs and airways.</li>
            </ol>'
    ]
];

// --- 2. DETERMINE VIEW MODE ---
// Check URL for ?id=X
$articleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isSingleView = ($articleId > 0 && isset($blogPosts[$articleId]));
$currentPost = $isSingleView ? $blogPosts[$articleId] : null;

// Set page title dynamic
$pageTitle = $isSingleView ? $currentPost['title'] : 'Health Blog & Tips';
$pageKey = 'blog';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle . ' - Medicare Plus'; ?></title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>

    <style>
        /* --- GLOBAL STYLES --- */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f7f6;
            line-height: 1.6;
        }

        /* --- PAGE CONTAINER --- */
        .page-container {
            width: 85%;
            max-width: 900px;
            margin: 40px auto;
            padding: 30px 40px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(12, 12, 12, 0.08);
        }

        /* --- TEXT STYLES --- */
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

        /* --- BUTTONS --- */
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

        /* --- BLOG GRID (List View) --- */
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
            margin-bottom: 20px;
            margin-top: 0;
        }

        .blog-content a.button {
            margin-top: auto;
            align-self: flex-start;
        }

        /* --- SINGLE ARTICLE STYLES --- */
        .single-article {
            animation: fadeIn 0.5s ease;
        }

        .article-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .article-meta {
            color: #666;
            font-style: italic;
            margin-bottom: 20px;
        }

        .article-img-container {
            width: 100%;
            height: 400px;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .article-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .article-body {
            font-size: 1.15em;
            color: #333;
            line-height: 1.8;
        }

        .article-body h3 {
            color: #1e3a8a;
            margin-top: 35px;
            font-size: 1.4em;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            color: #555;
            text-decoration: none;
            font-weight: bold;
        }

        .back-btn:hover {
            color: #57c95a;
        }

        /* --- RELATED POSTS SECTION --- */
        .related-section {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid #eee;
        }

        .related-title {
            font-size: 1.5em;
            color: #1e3a8a;
            margin-bottom: 20px;
        }

        /* --- VIDEO SECTION --- */
        .video-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            margin-top: 30px;
        }

        .video-card {
            background-color: #fdfdfd;
            border: 1px solid #e9e9e9;
            border-radius: 10px;
            overflow: hidden;
        }

        .video-embed {
            position: relative;
            padding-bottom: 56.25%;
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
            margin: 0 0 10px 0;
        }

        /* --- RESPONSIVE --- */
        @media screen and (max-width: 768px) {

            .blog-list,
            .video-list {
                grid-template-columns: 1fr;
            }

            .page-container {
                width: 95%;
                padding: 20px 15px;
            }

            .article-img-container {
                height: 250px;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <?php if (file_exists('header.php')) include 'header.php'; ?>

    <main class="page-container">

        <?php
        // =========================================================
        // VIEW 1: SINGLE ARTICLE MODE
        // =========================================================
        if ($isSingleView):
        ?>
            <div class="single-article">
                <a href="blog.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to All Articles</a>

                <div class="article-header">
                    <h2><?php echo htmlspecialchars($currentPost['title']); ?></h2>
                    <div class="article-meta">
                        <span><?php echo htmlspecialchars($currentPost['category']); ?></span> |
                        <span><?php echo htmlspecialchars($currentPost['date']); ?></span>
                    </div>
                </div>

                <div class="article-img-container">
                    <img src="<?php echo htmlspecialchars($currentPost['image']); ?>" alt="<?php echo htmlspecialchars($currentPost['title']); ?>">
                </div>

                <div class="article-body">
                    <?php echo $currentPost['content']; ?>
                </div>

                <hr style="margin: 40px 0; border: 0; border-top: 1px solid #f0f0f0;">
                <div style="background: #f9fafb; padding: 25px; border-radius: 8px; text-align: center;">
                    <h3 style="margin-top: 0;">Need medical advice?</h3>
                    <p>Our specialists at Medicare Plus are available for consultations.</p>
                    <a href="contact.php" class="button">Contact Us</a>
                </div>

                <div class="related-section">
                    <h3 class="related-title">You might also like</h3>
                    <div class="blog-list">
                        <?php
                        // Logic: Get all keys, remove current ID, shuffle, pick 3
                        $allKeys = array_keys($blogPosts);
                        $otherKeys = array_diff($allKeys, [$articleId]);
                        shuffle($otherKeys);
                        $relatedKeys = array_slice($otherKeys, 0, 3); // Show 3 related

                        foreach ($relatedKeys as $rId):
                            $rPost = $blogPosts[$rId];
                        ?>
                            <div class="blog-card">
                                <img src="<?php echo $rPost['image']; ?>" alt="<?php echo htmlspecialchars($rPost['title']); ?>">
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <span><?php echo htmlspecialchars($rPost['category']); ?></span>
                                    </div>
                                    <h4 style="font-size: 1.1em;"><?php echo htmlspecialchars($rPost['title']); ?></h4>
                                    <a href="blog.php?id=<?php echo $rId; ?>" class="button" style="margin-top: auto; padding: 5px 15px; font-size: 0.9em;">Read</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        <?php
        // =========================================================
        // VIEW 2: LIST MODE (GRID)
        // =========================================================
        else:
        ?>

            <div class="service-detail">
                <h2>Health Blog & Tips</h2>
                <p>Explore our latest articles on health, wellness, and medical advancements, written by the expert team at Medicare Plus.</p>
            </div>

            <div class="blog-list">
                <?php foreach ($blogPosts as $id => $post): ?>
                    <div class="blog-card">
                        <img src="<?php echo $post['image']; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><?php echo htmlspecialchars($post['category']); ?></span> | <?php echo $post['date']; ?>
                            </div>
                            <h4><?php echo htmlspecialchars($post['title']); ?></h4>
                            <p>
                                <?php
                                echo substr(strip_tags($post['content']), 0, 90) . '...';
                                ?>
                            </p>
                            <a href="blog.php?id=<?php echo $id; ?>" class="button">Read More</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <hr style="margin-top: 40px; margin-bottom: 30px; border: 1px solid #f0f0f0;">

            <div class="service-detail">
                <h2>Health Videos</h2>
                <p>Watch our health experts discuss important topics, share tips, and answer common questions.</p>
            </div>

            <div class="video-list">
                <div class="video-card">
                    <div class="video-embed">
                        <iframe src="https://www.youtube.com/embed/gC_L9qAHVJ8" title="Blood Pressure" allowfullscreen></iframe>
                    </div>
                    <div class="video-content">
                        <h4>Understanding Blood Pressure</h4>
                        <p>Dr. Perera explains what your blood pressure numbers mean.</p>
                    </div>
                </div>
                <div class="video-card">
                    <div class="video-embed">
                        <iframe src="https://www.youtube.com/embed/UYMmtEFhuxA" title="Back Pain Stretches" allowfullscreen></iframe>
                    </div>
                    <div class="video-content">
                        <h4>5-Minute Stretches for Back Pain</h4>
                        <p>A quick, real-time guide from our physiotherapy department.</p>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </main>

    <?php if (file_exists('footer.php')) include 'footer.php'; ?>
</body>

</html>