<?php
// --- 1. PAGE CONFIGURATION ---
$pageTitle = 'Doctor Profile';
$pageKey = 'find_doctor';

// Get Doctor ID safely
$doctorId = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'gotabhaya-ranasinghe';

// --- 2. INCLUDE HEADER (This file should contain your <html>, <head>, favicon, and opening <body> tags) ---
include 'header.php';
?>

<style>
    /* Main Container */
    .mp-container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }

    /* Profile Card */
    .mp-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border-top: 6px solid #003b95;
        /* Primary Blue */
        margin-bottom: 40px;
    }

    .mp-card-body {
        padding: 40px;
    }

    /* Header Layout (Flexbox) */
    .mp-profile-header {
        display: flex;
        gap: 30px;
        border-bottom: 1px solid #eee;
        padding-bottom: 30px;
        margin-bottom: 30px;
    }

    .mp-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #22c55e;
        /* Secondary Green */
        background-color: #f0f0f0;
        flex-shrink: 0;
    }

    .mp-info-col {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .mp-name {
        margin: 0;
        font-size: 2.2rem;
        color: #003b95;
        font-weight: 700;
    }

    .mp-title {
        margin: 5px 0 10px;
        color: #666;
        font-style: italic;
    }

    .mp-spec {
        margin: 0 0 15px;
        color: #22c55e;
        font-weight: bold;
        font-size: 1.2rem;
    }

    /* Ratings & Buttons */
    .mp-rating-display {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .mp-stars-text {
        color: #eab308;
        font-size: 1.2rem;
        letter-spacing: 2px;
    }

    .mp-btn {
        display: inline-block;
        background-color: #003b95;
        color: #fff;
        padding: 12px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: bold;
        width: fit-content;
        border: none;
        cursor: pointer;
        transition: background 0.3s;
    }

    .mp-btn:hover {
        background-color: #002a6b;
    }

    .mp-btn:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    /* Content Grid */
    .mp-details-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
    }

    .mp-section-h3 {
        color: #003b95;
        border-bottom: 2px solid #22c55e;
        padding-bottom: 8px;
        margin-bottom: 15px;
        font-size: 1.4rem;
    }

    .mp-bio-text {
        text-align: justify;
        line-height: 1.6;
        color: #444;
    }

    .mp-list {
        margin-left: 20px;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .mp-avail-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        font-weight: bold;
        color: #555;
        border: 1px solid #e9ecef;
    }

    /* Review Section */
    .mp-review-wrapper {
        margin-top: 50px;
    }

    .mp-review-form {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 30px;
    }

    .mp-star-input span {
        font-size: 30px;
        cursor: pointer;
        color: #ccc;
        transition: color 0.2s;
    }

    .mp-star-input span.active {
        color: #eab308;
    }

    .mp-input-textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-top: 10px;
        font-family: inherit;
        box-sizing: border-box;
    }

    .mp-review-item {
        background: #fff;
        border: 1px solid #eee;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .mp-profile-header {
            flex-direction: column;
            text-align: center;
            align-items: center;
        }

        .mp-details-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<main class="mp-container">

    <section class="mp-card">
        <div class="mp-card-body">
            <div class="mp-profile-header">
                <img id="doctor-img" class="mp-avatar" src="" alt="Doctor Profile" onerror="this.src='https://placehold.co/150?text=No+Img'">

                <div class="mp-info-col">
                    <h1 id="doctor-name" class="mp-name">Loading...</h1>
                    <p id="doctor-title" class="mp-title"></p>
                    <p id="doctor-spec" class="mp-spec"></p>

                    <div class="mp-rating-display">
                        <span id="avg-stars" class="mp-stars-text"></span>
                        <strong id="avg-score" style="color:#333;"></strong>
                        <span id="review-count" style="color:#777; font-size:0.9rem;"></span>
                    </div>

                    <a href="mailto:appointments@medicareplus.com" class="mp-btn">Book Appointment</a>
                </div>
            </div>

            <div class="mp-details-grid">
                <div>
                    <h3 class="mp-section-h3">Biography</h3>
                    <p id="doctor-desc" class="mp-bio-text"></p>
                </div>

                <div>
                    <h3 class="mp-section-h3" style="font-size:1.2rem;">Education</h3>
                    <ul id="doctor-edu" class="mp-list"></ul>

                    <h3 class="mp-section-h3" style="font-size:1.2rem;">Affiliations</h3>
                    <ul id="doctor-aff" class="mp-list"></ul>

                    <h3 class="mp-section-h3" style="font-size:1.2rem;">Availability</h3>
                    <div id="doctor-avail" class="mp-avail-box"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="mp-review-wrapper">
        <h2 style="color:#003b95; margin-bottom:20px;">Patient Reviews</h2>

        <div class="mp-review-form">
            <h3 style="margin-top:0; color:#22c55e;">Write a Review</h3>
            <form id="review-form">
                <div style="margin-bottom:15px;">
                    <label style="font-weight:bold;">Your Rating:</label><br>
                    <div id="star-widget" class="mp-star-input">
                        <span data-val="1">★</span><span data-val="2">★</span><span data-val="3">★</span><span data-val="4">★</span><span data-val="5">★</span>
                    </div>
                    <input type="hidden" id="rating-val" value="0">
                </div>

                <div style="margin-bottom:15px;">
                    <label style="font-weight:bold;">Your Feedback:</label>
                    <textarea id="review-msg" rows="3" class="mp-input-textarea" placeholder="Share your experience..."></textarea>
                </div>

                <button type="submit" id="submit-btn" class="mp-btn" style="width:100%;" disabled>Submit Review</button>
                <p id="status-msg" style="text-align:center; margin-top:10px; color:green; font-weight:bold;"></p>
            </form>
        </div>

        <div id="reviews-container">
            <div style="text-align:center; padding:30px; color:#888;">Loading reviews...</div>
        </div>
    </section>

</main>

<?php
// --- 5. INCLUDE FOOTER (This file should contain </body> and </html>) ---
include 'footer.php';
?>

<script>
    // PHP to JS
    const DOC_ID = <?php echo json_encode($doctorId); ?>;

    // Data
    const DB = {
        'gotabhaya-ranasinghe': {
            name: 'Dr. Gotabhaya Ranasinghe',
            title: 'Senior Consultant Cardiologist, MD, FRCP',
            spec: 'Cardiology',
            img: 'https://placehold.co/150x150/1e3a8a/ffffff?text=DR+G.R.',
            desc: 'A distinguished physician specializing in interventional cardiology, complex coronary procedures, and non-invasive cardiovascular assessment. Dr. Ranasinghe is certified in advanced life support and holds a prestigious fellowship from the American College of Cardiology.',
            edu: ['MBBS (Colombo)', 'MD (Cardiology)', 'FRCP (London)'],
            aff: ['Colombo Medical Society', 'European Society of Cardiology'],
            avail: 'Mon, Wed, Fri (10:00 AM - 1:00 PM)'
        },
        'default': {
            name: 'Doctor Not Found',
            title: '',
            spec: 'General',
            img: 'https://placehold.co/150?text=N/A',
            desc: 'Profile details unavailable.',
            edu: [],
            aff: [],
            avail: 'N/A'
        }
    };

    const LS_KEY = 'medicare_v4';

    document.addEventListener('DOMContentLoaded', () => {
        loadData();
        initForm();
        renderReviews();
    });

    function loadData() {
        const d = DB[DOC_ID] || DB['default'];

        // Safe text setter
        const txt = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.textContent = val;
        };

        txt('doctor-name', d.name);
        txt('doctor-title', d.title);
        txt('doctor-spec', d.spec);
        txt('doctor-desc', d.desc);
        txt('doctor-avail', d.avail);

        const img = document.getElementById('doctor-img');
        if (img) img.src = d.img;

        const list = (id, arr) => {
            const ul = document.getElementById(id);
            if (ul) ul.innerHTML = arr.length ? arr.map(x => `<li>${x}</li>`).join('') : '<li>N/A</li>';
        };
        list('doctor-edu', d.edu);
        list('doctor-aff', d.aff);
    }

    function getStars(n) {
        let s = '';
        for (let i = 1; i <= 5; i++) s += i <= n ? '★ ' : '☆ ';
        return s;
    }

    function renderReviews() {
        const raw = localStorage.getItem(LS_KEY);
        const all = raw ? JSON.parse(raw) : [];
        const mine = all.filter(r => r.docId === DOC_ID);

        // Stats
        const count = mine.length;
        const avg = count ? (mine.reduce((a, b) => a + b.rating, 0) / count) : 0;

        const tAvg = document.getElementById('avg-score');
        if (tAvg) tAvg.textContent = count ? avg.toFixed(1) : "0.0";

        const tStars = document.getElementById('avg-stars');
        if (tStars) tStars.textContent = getStars(Math.round(avg));

        const tCount = document.getElementById('review-count');
        if (tCount) tCount.textContent = `(${count} reviews)`;

        // Render List
        const box = document.getElementById('reviews-container');
        if (!box) return;
        box.innerHTML = '';

        if (count === 0) {
            box.innerHTML = '<div style="text-align:center; color:#888; background:#f9f9f9; padding:20px; border-radius:8px;">No reviews yet.</div>';
            return;
        }

        mine.sort((a, b) => b.date - a.date).forEach(r => {
            const div = document.createElement('div');
            div.className = 'mp-review-item';
            div.innerHTML = `
                <div style="display:flex; justify-content:space-between; color:#888; font-size:0.9rem; margin-bottom:5px;">
                    <strong>Patient Review</strong>
                    <span>${new Date(r.date).toLocaleDateString()}</span>
                </div>
                <div style="color:#eab308; margin-bottom:8px; letter-spacing:2px;">${getStars(r.rating)}</div>
                <div style="color:#555;">${r.text}</div>
            `;
            box.appendChild(div);
        });
    }

    function initForm() {
        const stars = document.querySelectorAll('#star-widget span');
        const inputVal = document.getElementById('rating-val');
        const inputText = document.getElementById('review-msg');
        const btn = document.getElementById('submit-btn');
        const form = document.getElementById('review-form');

        // Stars Interactive
        stars.forEach(s => {
            s.addEventListener('click', function() {
                const v = this.getAttribute('data-val');
                inputVal.value = v;
                stars.forEach(st => {
                    st.classList.toggle('active', st.getAttribute('data-val') <= v);
                });
                check();
            });
        });

        inputText.addEventListener('input', check);

        function check() {
            const r = parseInt(inputVal.value);
            const t = inputText.value.trim();
            btn.disabled = !(r > 0 && t.length >= 5);
        }

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const review = {
                docId: DOC_ID,
                rating: parseInt(inputVal.value),
                text: inputText.value.trim(),
                date: Date.now()
            };

            const raw = localStorage.getItem(LS_KEY);
            const all = raw ? JSON.parse(raw) : [];
            all.push(review);
            localStorage.setItem(LS_KEY, JSON.stringify(all));

            document.getElementById('status-msg').textContent = "Review Submitted!";

            setTimeout(() => {
                form.reset();
                inputVal.value = 0;
                stars.forEach(s => s.classList.remove('active'));
                document.getElementById('status-msg').textContent = "";
                btn.disabled = true;
                renderReviews();
            }, 1000);
        });
    }
</script>