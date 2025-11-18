<?php
$pageTitle = 'FAQ';
$pageKey = 'faq'; // Define a key for navigation/tracking

// Define the content for the FAQ
$faqs = [
    [
        'question' => 'How can I schedule an appointment with a specialist?',
        'answer' => 'You can schedule an appointment in three ways: 
            (1) **Online:** Use the "Book Appointment" form on our homepage. 
            (2) **By Phone:** Call our general line at +94 11 234 5678 during business hours (8:00 AM - 5:00 PM). 
            (3) **In Person:** Visit our main reception desk.',
        'tag' => 'Appointments',
    ],
    [
        'question' => 'What insurance plans does Medicare Plus accept?',
        'answer' => 'We accept most major local and international health insurance providers. For a specific plan inquiry, please call our billing department directly, or refer to the list provided on our dedicated "Billing & Insurance" page.',
        'tag' => 'Billing',
    ],
    [
        'question' => 'What are your hospital visiting hours?',
        'answer' => 'General patient visiting hours are from **10:00 AM to 1:00 PM** and **4:00 PM to 7:00 PM** daily. Please note that hours may vary for specialized units (ICU, Maternity) and are subject to change based on patient care needs.',
        'tag' => 'General',
    ],
    [
        'question' => 'How can I get copies of my medical records?',
        'answer' => 'You must submit a written request to our Health Information Management (HIM) department. Download the necessary "Authorization for Release of Information" form from our website, fill it out, and submit it in person or via email to info@medicareplus.lk.',
        'tag' => 'Records',
    ],
    [
        'question' => 'Do I need a referral to see a specialist?',
        'answer' => 'This depends entirely on your specific insurance policy. Please check with your insurance provider directly before booking. If your policy requires a referral, you must obtain it from your primary care physician first.',
        'tag' => 'Appointments',
    ],
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Medicare Plus' : 'FAQ - Medicare Plus'; ?></title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>

    <style>
        /* CSS Variables (Replicated from chat page) */
        :root {
            --primary-blue: #1e3a8a;
            --primary-green: #57c95a;
            --primary-green-dark: #45a049;
            --text-dark: #333;
            --text-light: #666;
            --bg-light: #f4f7f6;
            --bg-white: #ffffff;
            --border-light: #e9e9e9;
            --shadow-md: 0 5px 15px rgba(12, 12, 12, 0.08);
        }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .page-container {
            width: 85%;
            max-width: 900px;
            margin: 40px auto;
            padding: 30px 40px;
            background-color: var(--bg-white);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
        }

        .faq-intro-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .faq-intro-section h2 {
            font-size: 2.5em;
            color: var(--primary-blue);
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 3px solid var(--primary-green);
            display: inline-block;
        }

        /* FAQ Item Styling (Accordion) */
        .faq-item {
            border: 1px solid var(--border-light);
            border-radius: 8px;
            margin-bottom: 15px;
            overflow: hidden;
            background-color: var(--bg-white);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .faq-question {
            padding: 18px 25px;
            font-size: 1.1em;
            font-weight: 600;
            color: var(--text-dark);
            background-color: #f9f9f9;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.2s;
        }

        .faq-question:hover {
            background-color: #f0f0f0;
        }

        .faq-question i {
            color: var(--primary-green);
            transition: transform 0.3s;
        }

        /* Active state for question */
        .faq-item.active .faq-question {
            background-color: var(--primary-blue);
            color: var(--bg-white);
            border-bottom: 1px solid var(--primary-blue);
        }

        .faq-item.active .faq-question i {
            color: var(--bg-white);
            transform: rotate(180deg);
        }

        .faq-answer {
            padding: 0 25px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-in-out, padding 0.4s ease-in-out;
            background-color: var(--bg-white);
            color: var(--text-light);
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
            /* Large enough value to cover all answers */
            padding: 15px 25px 20px;
        }
    </style>
</head>

<body>



    <main class="page-container">
        <section class="faq-intro-section">
            <h2><i class="fa-solid fa-circle-question"></i> Need Help Fast?</h2>
            <p style="font-size: 1.1em; color: var(--text-light);">Find answers to the most common questions about our services, appointments, and hospital information below.</p>
        </section>

        <section class="faq-list">
            <?php foreach ($faqs as $faq) : ?>
                <div class="faq-item">
                    <div class="faq-question">
                        <span><?php echo htmlspecialchars($faq['question']); ?></span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo nl2br(htmlspecialchars($faq['answer'])); ?></p>
                        <small style="color: var(--primary-blue); font-weight: 600;">Category: <?php echo htmlspecialchars($faq['tag']); ?></small>
                    </div>
                </div>
            <?php endforeach; ?>

            <div style="text-align: center; margin-top: 40px;">
                <p style="font-size: 1.1em; color: var(--text-dark);">
                    Still can't find the answer?
                </p>
                <a href="chat_with_us.php" class="button-large" style="background-color: var(--primary-green); color: white; padding: 12px 25px; border-radius: 30px; text-decoration: none; font-weight: 700;">
                    <i class="fa-solid fa-comments"></i> Chat With Us
                </a>
            </div>
        </section>

    </main>

    <?php include 'footer.php'; // Assuming you have a standard footer 
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                question.addEventListener('click', () => {
                    // Close all other open FAQ items
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item && otherItem.classList.contains('active')) {
                            otherItem.classList.remove('active');
                        }
                    });

                    // Toggle the clicked item
                    item.classList.toggle('active');
                });
            });
        });
    </script>

</body>

</html>