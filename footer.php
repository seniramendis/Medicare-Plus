<style>
    /* --- FOOTER STYLES --- */
    .site-footer {
        background-color: #181818;
        color: #ccc;
        padding: 60px 40px 20px 40px;
        line-height: 1.7;
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
        filter: brightness(0) invert(1) contrast(0.8);
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
            <h3 style="margin-left: 100px;">QUICK LINKS</h3>
            <ul class="footer-links">
                <li><a href="<?php echo $links['services']; ?>">Our Services</a></li>
                <li><a href="<?php echo $links['find_doctor']; ?>">Find a Doctor</a></li>
                <li><a href="<?php echo $links['blog']; ?>">Health Blog & Tips</a></li>
                <li><a href="<?php echo $links['location']; ?>">Location</a></li>
                <li><a href="<?php echo $links['about']; ?>">About Us</a></li>
                <li><a href="<?php echo $links['contact']; ?>">Contact</a></li>
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

<?php if (isset($pageKey) && $pageKey == 'home'): ?>
    <script src="first.js" type="text/javascript"></script>
<?php endif; ?>