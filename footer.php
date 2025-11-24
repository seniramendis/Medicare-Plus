<style>
    /* --- STANDARD FOOTER STYLES --- */
    .site-footer {
        background-color: #181818;
        color: #ccc;
        padding: 60px 40px 20px 40px;
        line-height: 1.7;
        font-family: Arial, sans-serif;
        /* Ensure basic font consistency */
    }

    .footer-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 30px;
        margin-bottom: 40px;
    }

    .footer-column {
        flex: 1;
        min-width: 230px;
    }

    .footer-logo {
        width: 130px;
        height: auto;
        margin-bottom: 15px;

    }

    .footer-column h3 {
        color: #ffffff;
        font-size: 16px;
        text-transform: uppercase;
        margin-bottom: 25px;
    }

    .site-footer p {
        color: #ccc;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 12px;
    }

    .footer-links a {
        color: #ccc;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .footer-links a:hover {
        color: #57c95a;
    }

    .footer-contact {
        list-style: none;
        padding: 0;
        margin: 0;
        color: #ccc;
    }

    .footer-contact li {
        margin-bottom: 12px;
        font-size: 14px;
        display: flex;
        align-items: center;
    }

    .footer-contact i {
        color: #57c95a;
        margin-right: 12px;
        width: 20px;
        text-align: center;
    }

    .footer-contact a {
        color: #ccc;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .footer-contact a:hover {
        color: #57c95a;
    }

    .footer-bottom {
        border-top: 1px solid #444;
        padding-top: 25px;
        text-align: center;
    }

    .footer-socials {
        margin-bottom: 15px;
    }

    .footer-socials a {
        color: #ccc;
        margin: 0 12px;
        font-size: 16px;
        text-decoration: none;
    }

    .footer-socials a:hover {
        color: #57c95a;
    }

    /* --- RESPONSIVE STYLES (Footer) --- */
    @media screen and (max-width: 600px) {
        .footer-container {
            flex-direction: column;
            align-items: center;
        }

        .footer-column {
            width: 90%;
            max-width: 350px;
            text-align: center;
        }

        .site-footer p,
        .footer-links li {
            text-align: center;
        }

        .footer-contact li,
        .footer-contact a {
            justify-content: center;
        }

        .footer-logo {
            margin-left: auto;
            margin-right: auto;
        }
    }
</style>

<footer class="site-footer">
    <div class="footer-container">

        <div class="footer-column about-us">
            <img src="images/Logo4.png" alt="Medicare Plus Logo" class="footer-logo">
            <p>Welcome to MediCare Plus, a leading private healthcare provider dedicated to delivering a
                comprehensive range of medical services.</p>
            <p class="footer-address">
                Medicare Plus<br>
                No. 84 St.Rita's Road,<br>
                Mount Lavinia,<br>
                Sri Lanka
            </p>
        </div>

        <div class="footer-column quick-links">
            <h3 style="margin-left: 0;">QUICK LINKS</h3>
            <ul class="footer-links">
                <li><a href="<?php echo isset($links['services']) ? $links['services'] : 'services.php'; ?>">Our Services</a></li>
                <li><a href="<?php echo isset($links['find_doctor']) ? $links['find_doctor'] : 'find_a_doctor.php'; ?>">Find a Doctor</a></li>
                <li><a href="<?php echo isset($links['blog']) ? $links['blog'] : 'blog.php'; ?>">Health Blog & Tips</a></li>
                <li><a href="<?php echo isset($links['location']) ? $links['location'] : 'location.php'; ?>">Location</a></li>
                <li><a href="<?php echo isset($links['about']) ? $links['about'] : '#AboutUs'; ?>">About Us</a></li>
                <li><a href="<?php echo isset($links['contact']) ? $links['contact'] : 'contact.php'; ?>">Contact</a></li>
            </ul>
        </div>

        <div class="footer-column make-appointment">
            <h3>MAKE AN APPOINTMENT</h3>
            <p>To schedule an appointment, please contact our office directly during business hours or use our
                convenient online booking portal.
                Our team is ready to assist you in finding a date and time that best fits your schedule.</p>
            <ul class="footer-contact">
                <li><i class="fa-solid fa-clock"></i> 8:00 AM - 11:00 AM</li>
                <li><i class="fa-solid fa-clock"></i> 2:00 PM - 05:00 PM</li>
                <li><i class="fa-solid fa-clock"></i> 8:00 PM - 11:00 PM</li>
                <li>
                    <a href="mailto:support@medicareplus.com">
                        <i class="fa-solid fa-envelope"></i> support@medicareplus.com
                    </a>
                </li>
                <li><a href="tel:+94112499590">
                        <i class="fa-solid fa-phone"></i> +94 11 2 499 590
                    </a></li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-socials">
            <a href="https://x.com/" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
            <a href="https://facebook.com/" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://www.linkedin.com/" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
        </div>
        <p>© 2025 Medicare Plus. All rights reserved.</p>
    </div>
</footer>

<style>
    /* These styles use !important to override any conflicting styles 
       from other pages (like services.php) and use hardcoded colors 
       so they don't disappear if CSS variables are missing.
    */

    .chat-button {
        position: fixed !important;
        right: 25px !important;
        width: 60px !important;
        height: 60px !important;
        border-radius: 50% !important;

        /* Hardcoded Colors (White Text) */
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;

        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        font-size: 24px !important;
        text-decoration: none !important;
        z-index: 9999 !important;
        /* Keep on top of everything */
        transition: transform 0.3s ease !important;
    }

    /* Chat Button (Bottom) - Medicare Green */
    #chat-widget {
        bottom: 25px !important;
        background-color: #57c95a !important;
    }

    /* FAQ Button (Top) - Blue (to distinguish from chat) */
    #faq-widget {
        bottom: 100px !important;
        background-color: #0056b3 !important;
    }

    /* Hover Effects */
    .chat-button:hover {
        transform: scale(1.1) !important;
        filter: brightness(1.1);
        /* Makes it slightly brighter on hover */
    }

    /* Mobile Adjustments */
    @media screen and (max-width: 480px) {
        .chat-button {
            width: 50px !important;
            height: 50px !important;
            right: 15px !important;
            font-size: 20px !important;
        }

        #chat-widget {
            bottom: 15px !important;
        }

        #faq-widget {
            bottom: 80px !important;
        }
    }
</style>

<a href="faq.php" id="faq-widget" class="chat-button" title="Frequently Asked Questions">
    <i class="fa-solid fa-circle-question"></i>
</a>

<a href="chat_with_us.php" id="chat-widget" class="chat-button" title="Chat with us" target="_blank">
    <i class="fa-solid fa-comment-dots"></i>
</a>

<?php if (isset($pageKey) && $pageKey == 'home'): ?>
    <script src="first.js" type="text/javascript"></script>
<?php endif; ?>