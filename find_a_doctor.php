<?php
// find_a_doctor.php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Connect to Database
if (file_exists('db_connect.php')) {
    include 'db_connect.php';
} else {
    // Fallback if file not found (prevents crash)
    die("Database connection file missing.");
}

$pageTitle = 'Find a Doctor';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Medicare Plus</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>

    <style>
        /* --- 1. GLOBAL BODY STYLES --- */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f7f6;
            line-height: 1.6;
        }

        /* --- 2. PAGE-SPECIFIC STYLES --- */
        .page-container {
            width: 85%;
            max-width: 1200px;
            /* Increased width for better grid */
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

        /* Filter Bar */
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .filter-bar input[type="text"],
        .filter-bar select {
            flex: 1;
            min-width: 250px;
            height: 48px;
            padding: 0 20px;
            font-size: 16px;
            color: #333;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 24px;
            transition: all 0.3s ease;
        }

        .filter-bar select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            padding-right: 45px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%23555'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd' /%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 20px 20px;
        }

        .filter-bar input[type="text"]:focus,
        .filter-bar select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2);
        }

        /* Doctor List */
        .doctor-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            /* Responsive Grid */
            gap: 25px;
        }

        .doctor-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            padding: 25px;
            background-color: #fdfdfd;
            border: 1px solid #e9e9e9;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(30, 58, 138, 0.1);
        }

        .doctor-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #1e3a8a;
        }

        .doctor-info {
            text-align: center;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            width: 100%;
        }

        .doctor-card h4 {
            font-size: 1.4em;
            color: #1e3a8a;
            margin-top: 0;
            margin-bottom: 5px;
        }

        .doctor-title {
            font-size: 1em;
            font-weight: bold;
            color: #555;
            margin-top: 0;
            margin-bottom: 5px;
        }

        .doctor-specialty {
            font-size: 0.9em;
            font-weight: 500;
            color: #57c95a;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 0;
            margin-bottom: 12px;
        }

        .doctor-rating {
            margin-bottom: 15px;
            font-size: 0.9em;
        }

        .doctor-rating .fa-star,
        .doctor-rating .fa-star-half-stroke,
        .doctor-rating .fa-regular {
            color: #f0ad4e;
        }

        .doctor-rating span {
            color: #777;
            margin-left: 8px;
        }

        .doctor-description {
            font-size: 0.9em;
            color: #666;
            line-height: 1.5;
            flex-grow: 1;
            margin-bottom: 15px;
            margin-top: 0;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            /* Limit text to 3 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .doctor-info a.button {
            margin-top: auto;
        }

        #noResultsMessage {
            text-align: center;
            color: #777;
            width: 100%;
            grid-column: 1 / -1;
        }

        /* --- 3. PAGE-SPECIFIC RESPONSIVE STYLES --- */
        @media screen and (max-width: 600px) {
            .page-container {
                width: 95%;
                padding: 20px 15px;
            }

            .doctor-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <?php if (file_exists('header.php')) include 'header.php'; ?>

    <main class="page-container">
        <div class="service-detail">
            <h2>Find a Doctor</h2>
            <p>Search for our specialists by name or filter by department to find the right doctor for your needs.</p>

            <div style="width:100%; height:auto; margin-bottom: 30px; text-align:center;">
                <img src="images/doctors-banner.jpg" alt="Medical Specialists" style="max-width:100%; border-radius:10px;" onerror="this.style.display='none'">
            </div>
        </div>

        <div class="filter-bar">
            <input type="text" id="doctorName" placeholder="Search by Doctor's Name...">
            <select id="doctorSpecialty">
                <option value="all">All Specialties</option>
                <option value="Cardiology">Cardiology</option>
                <option value="Dermatology">Dermatology</option>
                <option value="Endocrinology">Endocrinology</option>
                <option value="ENT">ENT</option>
                <option value="General Practitioner">General Practitioner</option>
                <option value="Gynaecology">Gynaecology</option>
                <option value="Neurology">Neurology</option>
                <option value="Orthopedics">Orthopedics</option>
                <option value="Pediatrics">Pediatrics</option>
            </select>
        </div>

        <div class="doctor-list" id="allDoctorsList">
            <?php
            // --- DYNAMIC DOCTOR FETCHING START ---

            // Query to get doctors AND calculate their average rating/count from reviews table
            $sql = "SELECT d.*, 
                           (SELECT AVG(rating) FROM reviews r WHERE r.doctor_id = d.id) as avg_rating,
                           (SELECT COUNT(*) FROM reviews r WHERE r.doctor_id = d.id) as review_count
                    FROM doctors d";

            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Prepare Data
                    $name = htmlspecialchars($row['name']);
                    $specialty = htmlspecialchars($row['specialty']);
                    $title = htmlspecialchars($row['title']);
                    $slug = htmlspecialchars($row['slug']);

                    // Bio Preview (First 100 chars)
                    $bio = strip_tags($row['bio']);
                    if (strlen($bio) > 100) $bio = substr($bio, 0, 100) . '...';

                    // Image with CACHE BUSTER (?v=time)
                    $img = !empty($row['image_url']) ? htmlspecialchars($row['image_url']) : 'images/placeholder_doctor.png';
                    $img .= '?v=' . time();

                    // Ratings Logic
                    $rating = $row['avg_rating'] ? round($row['avg_rating'], 1) : 0;
                    $count = $row['review_count'];
                    $full_stars = floor($rating);
                    $has_half = ($rating - $full_stars) >= 0.5;
            ?>

                    <div class="doctor-card" data-name="<?php echo $name; ?>" data-specialty="<?php echo $specialty; ?>">
                        <img src="<?php echo $img; ?>" alt="<?php echo $name; ?>" onerror="this.src='images/placeholder_doctor.png'">
                        <div class="doctor-info">
                            <h4><?php echo $name; ?></h4>
                            <p class="doctor-title"><?php echo $title; ?></p>
                            <p class="doctor-specialty"><?php echo $specialty; ?></p>

                            <div class="doctor-rating">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $full_stars) {
                                        echo '<i class="fa-solid fa-star"></i>';
                                    } elseif ($i == $full_stars + 1 && $has_half) {
                                        echo '<i class="fa-solid fa-star-half-stroke"></i>';
                                    } else {
                                        echo '<i class="fa-regular fa-star"></i>';
                                    }
                                }
                                ?>
                                <span><?php echo $rating > 0 ? "$rating ($count)" : "No reviews yet"; ?></span>
                            </div>

                            <p class="doctor-description"><?php echo $bio; ?></p>
                            <a href="doctor-profile.php?slug=<?php echo $slug; ?>" class="button">View Profile</a>
                        </div>
                    </div>

            <?php
                }
            } else {
                echo '<p style="text-align:center; width:100%; grid-column:1/-1;">No doctors available at the moment.</p>';
            }
            // --- DYNAMIC FETCHING END ---
            ?>
        </div>

        <div id="noResultsMessage" style="display: none;">
            <h3>No doctors found matching your criteria.</h3>
        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('doctorName');
            const specialtySelect = document.getElementById('doctorSpecialty');
            const doctorList = document.getElementById('allDoctorsList');
            const allCards = doctorList ? doctorList.querySelectorAll('.doctor-card') : [];
            const noResultsMessage = document.getElementById('noResultsMessage');

            function filterDoctors() {
                if (!allCards.length) return;

                const nameQuery = nameInput.value.toLowerCase();
                const specialtyQuery = specialtySelect.value;
                let resultsFound = false;

                allCards.forEach(card => {
                    const name = (card.getAttribute('data-name') || '').toLowerCase();
                    const specialty = card.getAttribute('data-specialty');

                    const nameMatch = name.includes(nameQuery);
                    const specialtyMatch = (specialtyQuery === 'all' || specialty === specialtyQuery);

                    if (nameMatch && specialtyMatch) {
                        card.style.display = 'flex';
                        resultsFound = true;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (noResultsMessage) {
                    noResultsMessage.style.display = resultsFound ? 'none' : 'block';
                }
            }

            if (nameInput) nameInput.addEventListener('keyup', filterDoctors);
            if (specialtySelect) specialtySelect.addEventListener('change', filterDoctors);
        });
    </script>

    <?php if (file_exists('footer.php')) include 'footer.php'; ?>
</body>

</html>