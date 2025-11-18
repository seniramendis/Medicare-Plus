<?php
$pageTitle = 'Chat With Us';
$pageKey = 'contact';

// --- IMPORTANT: Define PHP variables for JS login state ---
// You MUST integrate this with your actual session/authentication system.
// This example uses placeholder logic for demonstration.
$isUserLoggedIn = false;
$userName = "Guest";

// Example placeholder for fetching user status from a session (if sessions were started)
if (isset($_SESSION['user_id'])) {
    $isUserLoggedIn = true;
    $userName = $_SESSION['first_name']; // Assumes $_SESSION['first_name'] is set
} else {
    $userName = 'Anonymous';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Medicare Plus' : 'Chat With Us - Medicare Plus'; ?></title>
    <link rel="icon" href="images/Favicon.png" type="image/png">

    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>

    <style>
        /* CSS Variables assumed to be defined globally or in the style sheet */
        :root {
            --primary-blue: #1e3a8a;
            --primary-blue-light: #2563eb;
            --primary-green: #57c95a;
            --primary-green-dark: #45a049;
            --text-dark: #333;
            --text-light: #666;
            --text-white: #ffffff;
            --border-light: #e9e9e9;
            --bg-light: #f4f7f6;
            --bg-white: #ffffff;
            --shadow-md: 0 5px 15px rgba(12, 12, 12, 0.08);
        }

        /* Basic Page Container and Text Styles (Replicated from home styles) */
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        h1,
        h2,
        h3,
        h4 {
            font-weight: 600;
            margin-top: 0;
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

        /* Chat Page Specific Styles */
        .chat-intro-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .chat-intro-section h2 {
            font-size: 2.2em;
            color: var(--primary-blue);
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 3px solid var(--primary-green);
            display: inline-block;
        }

        .chat-options-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 40px;
            text-align: left;
        }

        .chat-embed-area {
            min-height: 400px;
            background-color: var(--bg-light);
            border: 1px solid var(--border-light);
            border-radius: 10px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Contact List Styling */
        .contact-details h3 {
            color: var(--primary-blue);
            margin-bottom: 15px;
        }

        .footer-contact {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-contact li {
            font-size: 1rem;
            color: var(--text-dark);
            margin-bottom: 10px;
            display: flex;
            align-items: flex-start;
        }

        .footer-contact i {
            color: var(--primary-green);
            margin-right: 15px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .footer-contact .list-content {
            flex-grow: 1;
        }

        /* Link Color Fix: Ensure the link color is BLACK/DARK text */
        .footer-contact a {
            color: var(--text-dark) !important;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer-contact a:hover {
            color: var(--primary-green-dark) !important;
        }

        /* Style for the "Send" button (formerly "Start Chat") */
        .start-chat-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 700;
            background-color: var(--primary-blue);
            color: var(--text-white);
            border-radius: 30px;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 20px;
            justify-content: center;
        }

        .start-chat-button:hover {
            background-color: var(--primary-blue-light);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .button-large {
            display: inline-block;
            background-color: var(--primary-green);
            color: var(--text-white);
            padding: 10px 24px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .button-large:hover {
            background-color: var(--primary-green-dark);
        }

        /* New CSS for the Textarea */
        #chat-message-preview {
            width: 90%;
            max-width: 90%;
            padding: 10px;
            border: 1px solid var(--border-light);
            border-radius: 6px;
            resize: vertical;
            margin-bottom: 20px;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 0.95rem;
        }

        /* Responsive */
        @media screen and (max-width: 900px) {
            .chat-options-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <main class="page-container">
        <section class="chat-intro-section">
            <h2><i class="fa-solid fa-comment-dots"></i> Chat Support</h2>
            <p style="font-size: 1.1em; color: var(--text-light);">Connect instantly with our support team for quick answers to your questions about appointments, services, or hospital information.</p>
        </section>

        <div class="chat-options-grid">

            <div class="chat-embed-area" id="live-chat-area">
                <h3 id="chat-greeting">Hello, Guest!</h3>
                <p style="text-align: center; color: var(--text-light);">
                    Start a general conversation with hospital staff only.
                    *Do not share sensitive personal or medical details here.*
                </p>

                <label for="chat-message-preview" style="align-self: flex-start; margin-top: 15px; font-weight: 600; color: var(--text-dark); width: 90%; max-width: 90%;">
                    What is your question about? (Optional)
                </label>
                <textarea
                    id="chat-message-preview"
                    placeholder="E.g., What are your visiting hours? How do I book an appointment?"
                    rows="4"
                    title="Enter your preliminary question here"></textarea>
                <div style="width: 90%; background: var(--bg-white); border: 1px solid var(--border-light); border-radius: 8px; margin-top: 15px; padding: 15px; overflow-y: auto; display: none;">
                    <p style="text-align: center; color: var(--text-light);">[Third-party Live Chat Widget or Custom Form Embeds here]</p>
                </div>

                <a href="#" class="start-chat-button" id="start-chat-btn">
                    <i class="fa-solid fa-paper-plane"></i> Send Message
                </a>
            </div>

            <div class="side-options">
                <div class="contact-details">
                    <h3>Other Ways to Connect</h3>
                    <ul class="footer-contact">
                        <li>
                            <i class="fa-solid fa-phone"></i>
                            <span class="list-content">Call Us: <a href="tel:+94112345678"> +94 11 234 5678</a> (General Line)</span>
                        </li>

                        <li>
                            <i class="fa-solid fa-clock"></i>
                            <span class="list-content">Hours: 8:00 AM - 5:00 PM (Monday - Friday)</span>
                        </li>

                        <li>
                            <i class="fa-solid fa-envelope"></i>
                            <span class="list-content">Email: <a href="mailto:info@medicareplus.lk">info@medicareplus.lk</a> (Response within 24 hours)</span>
                        </li>
                    </ul>
                </div>

                <div class="faq-link" style="text-align: center; padding-top: 30px; border-top: 1px solid var(--border-light);">
                    <h3>Need Quick Answers?</h3>
                    <p>Check our detailed Frequently Asked Questions section before starting a chat.</p>
                    <a href="faq.php" class="button-large">View FAQ</a>
                </div>
            </div>

        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script>
        // --- PHP INJECTION: Read variables set at the top of the file ---
        const isUserLoggedIn = <?php echo $isUserLoggedIn ? 'true' : 'false'; ?>;
        const userName = '<?php echo $userName; ?>';

        document.addEventListener('DOMContentLoaded', function() {
            const chatGreeting = document.getElementById('chat-greeting');

            // Set the greeting based on the PHP variables
            if (chatGreeting) {
                if (isUserLoggedIn && userName !== 'Anonymous') {
                    // Logged in user greeting
                    chatGreeting.innerHTML = `<h3>Hello, ${userName}!</h3>`;
                } else {
                    // Anonymous user greeting
                    chatGreeting.innerHTML = `<h3>Hello, Anonymous!</h3>`;
                }
            }
        });
    </script>

</body>

</html>