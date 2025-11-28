<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// --- DEBUG MODE: WIDGET ALWAYS ON ---
$hide_chat_widget = false;
/* if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'doctor') {
    $hide_chat_widget = true;
}
*/
?>

<style>
    /* =========================================
       1. BASE FOOTER STYLES
       ========================================= */
    .site-footer {
        background-color: #1a1a1a;
        color: #b3b3b3;
        padding: 70px 0 0 0;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        line-height: 1.8;
        position: relative;
        z-index: 1;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 0 20px 50px 20px;
        gap: 40px;
    }

    .footer-column {
        flex: 1;
        min-width: 250px;
    }

    .footer-logo {
        width: 160px;
        height: auto;
        margin-bottom: 25px;
        display: block;
    }

    .footer-column p {
        margin-bottom: 20px;
        color: #ccc;
    }

    .footer-column h3 {
        color: #ffffff;
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 30px;
    }

    .footer-links,
    .footer-contact-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li,
    .footer-contact-list li {
        margin-bottom: 15px;
    }

    .footer-links a {
        color: #b3b3b3;
        text-decoration: none;
        transition: color 0.3s;
        display: inline-block;
    }

    .footer-links a:hover {
        color: #57c95a;
        padding-left: 5px;
    }

    .footer-contact-list li {
        display: flex;
        align-items: flex-start;
        color: #ccc;
    }

    .footer-contact-list i {
        color: #57c95a;
        font-size: 16px;
        margin-right: 15px;
        margin-top: 5px;
        width: 20px;
        flex-shrink: 0;
        /* Prevent icon from squishing */
    }

    .footer-contact-list a {
        color: #ccc;
        text-decoration: none;
        transition: 0.3s;
    }

    .footer-contact-list a:hover {
        color: #57c95a;
    }

    .footer-bottom {
        background-color: #111;
        border-top: 1px solid #333;
        padding: 25px 0;
        text-align: center;
        margin-top: 20px;
    }

    .footer-socials a {
        color: #b3b3b3;
        margin: 0 15px;
        font-size: 18px;
        transition: 0.3s;
        display: inline-block;
    }

    .footer-socials a:hover {
        color: #57c95a;
        transform: translateY(-3px);
    }

    /* =========================================
       2. WIDGET STYLES
       ========================================= */
    .chat-button {
        position: fixed !important;
        right: 25px !important;
        width: 65px !important;
        height: 65px !important;
        border-radius: 50% !important;
        color: #fff !important;
        box-shadow: 0 8px 25px rgba(87, 201, 90, 0.4) !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        font-size: 28px !important;
        z-index: 2147483647 !important;
        cursor: pointer;
        transition: transform 0.3s ease;
        border: 2px solid #fff;
        text-decoration: none !important;
    }

    .chat-button:hover {
        transform: scale(1.1);
    }

    #chat-widget-btn {
        bottom: 30px !important;
        background: linear-gradient(135deg, #57c95a, #2ca831) !important;
    }

    #faq-widget-btn {
        bottom: 110px !important;
        background: #1e3a8a !important;
        width: 50px !important;
        height: 50px !important;
        font-size: 22px !important;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2) !important;
    }

    .notify-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: #ef4444;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        font-size: 12px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid white;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .notify-badge.show {
        opacity: 1;
    }

    /* CHAT WINDOW */
    .chat-popup-window {
        display: none;
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 380px;
        height: 550px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        z-index: 2147483647 !important;
        flex-direction: column;
        overflow: hidden;
        font-family: 'Segoe UI', sans-serif;
        border: 1px solid rgba(0, 0, 0, 0.08);
    }

    .chat-popup-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        padding: 20px 25px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 2;
        min-height: 80px;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        background: #57c95a;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }

    .close-chat {
        font-size: 22px;
        cursor: pointer;
    }

    .chat-popup-body {
        flex: 1;
        background-color: #f3f4f6;
        padding: 0 20px 20px 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .chat-popup-body::before {
        content: '';
        display: block;
        min-height: 50px;
        width: 100%;
        flex-shrink: 0;
    }

    .message-bubble {
        padding: 12px 16px;
        border-radius: 16px;
        font-size: 14px;
        line-height: 1.5;
        position: relative;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        word-wrap: break-word;
    }

    .msg-time {
        font-size: 10px;
        margin-top: 5px;
        text-align: right;
        opacity: 0.7;
    }

    .user-msg {
        align-self: flex-end;
    }

    .user-msg .message-bubble {
        background: linear-gradient(135deg, #57c95a, #45a049);
        color: white;
        border-bottom-right-radius: 4px;
    }

    .user-msg .msg-time {
        color: rgba(255, 255, 255, 0.9);
    }

    .admin-msg {
        align-self: flex-start;
    }

    .admin-msg .message-bubble {
        background: white;
        color: #333;
        border-bottom-left-radius: 4px;
        border: 1px solid #e2e8f0;
    }

    .message-wrapper {
        display: flex;
        flex-direction: column;
        max-width: 85%;
        position: relative;
    }

    .user-del-btn {
        position: absolute;
        left: -35px;
        top: 50%;
        transform: translateY(-50%) scale(0.8);
        width: 28px;
        height: 28px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #ef4444;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
        z-index: 5;
    }

    .message-wrapper:hover .user-del-btn {
        opacity: 1;
        visibility: visible;
        transform: translateY(-50%) scale(1);
        left: -40px;
    }

    .chat-popup-footer {
        padding: 15px;
        background: #fff;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chat-input {
        flex: 1;
        padding: 12px 18px;
        border: 2px solid #f1f5f9;
        border-radius: 30px;
        outline: none;
        font-size: 14px;
        background: #f8fafc;
    }

    .send-icon-btn {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #1e3a8a, #2563eb);
        border: none;
        border-radius: 50%;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(30, 58, 138, 0.3);
    }

    /* =========================================
       3. RESPONSIVE QUERIES
       ========================================= */

    /* Tablet (max-width: 992px) */
    @media (max-width: 992px) {
        .footer-container {
            padding: 0 20px 40px 20px;
            gap: 30px;
        }
    }

    /* Mobile (max-width: 768px) */
    @media (max-width: 768px) {

        /* Footer Layout Stacked */
        .footer-container {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .footer-column {
            width: 100%;
            min-width: auto;
            margin-bottom: 10px;
        }

        .footer-logo {
            margin: 0 auto 20px auto;
            /* Center Logo */
        }

        /* Center list items on mobile */
        .footer-links li,
        .footer-contact-list li {
            justify-content: center;
        }

        /* Adjust hover effect on mobile */
        .footer-links a:hover {
            padding-left: 0;
            /* Remove shift on mobile */
            color: #57c95a;
        }

        .footer-contact-list i {
            margin-right: 10px;
        }

        /* Chat Buttons Sizing for Mobile */
        .chat-button {
            width: 55px !important;
            height: 55px !important;
            font-size: 24px !important;
            right: 15px !important;
        }

        #chat-widget-btn {
            bottom: 20px !important;
        }

        #faq-widget-btn {
            width: 40px !important;
            height: 40px !important;
            font-size: 18px !important;
            bottom: 90px !important;
            right: 22px !important;
            /* Align center with chat btn */
        }

        /* Chat Popup Fullscreen-ish on Mobile */
        .chat-popup-window {
            width: 90% !important;
            right: 5% !important;
            bottom: 85px !important;
            /* Above button */
            height: 60vh !important;
            border-radius: 15px;
        }
    }
</style>

<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-column">
            <img src="images/Logo4.png" alt="Medicare Plus" class="footer-logo">
            <p>Welcome to MediCare Plus, a leading private healthcare provider dedicated to delivering a comprehensive range of medical services.</p>
            <p>Medicare Plus<br>No. 84 St.Rita's Road,<br>Mount Lavinia,<br>Sri Lanka</p>
        </div>
        <div class="footer-column">
            <h3>QUICK LINKS</h3>
            <ul class="footer-links">
                <li><a href="services.php">Our Services</a></li>
                <li><a href="find_a_doctor.php">Find a Doctor</a></li>
                <li><a href="blog.php">Health Blog & Tips</a></li>
                <li><a href="location.php">Location</a></li>
                <li><a href="#AboutUs">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>MAKE AN APPOINTMENT</h3>
            <p>To schedule an appointment, please contact our office directly during business hours or use our convenient online booking portal.</p>
            <ul class="footer-contact-list">
                <li><i class="fa-regular fa-clock"></i> 8:00 AM - 11:00 AM</li>
                <li><i class="fa-regular fa-clock"></i> 2:00 PM - 05:00 PM</li>
                <li><i class="fa-regular fa-clock"></i> 8:00 PM - 11:00 PM</li>
                <li><a href="mailto:support@medicareplus.com"><i class="fa-regular fa-envelope"></i> support@medicareplus.com</a></li>
                <li><a href="tel:+94112499590"><i class="fa-solid fa-phone"></i> +94 11 2 499 590</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="footer-socials">
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
        </div>
        <p class="copyright-text">© 2025 Medicare Plus. All rights reserved.</p>
    </div>
</footer>

<a href="faq.php" id="faq-widget-btn" class="chat-button" title="FAQ"><i class="fa-solid fa-circle-question"></i></a>

<?php if (!$hide_chat_widget): ?>

    <div id="chat-widget-btn" class="chat-button" onclick="toggleChat()">
        <i class="fa-solid fa-comment-dots"></i>
        <span class="notify-badge" id="chat-badge">0</span>
    </div>

    <div id="chat-popup-window" class="chat-popup-window">
        <div class="chat-popup-header">
            <div class="header-info">
                <h4>Medicare Support</h4>
                <span><span class="status-dot"></span> Available 24/7</span>
            </div>
            <span class="close-chat" onclick="toggleChat()"><i class="fa-solid fa-xmark"></i></span>
        </div>

        <div class="chat-popup-body" id="chat-body">
            <div style="text-align:center; color:#94a3b8; margin-top:60px;">
                <i class="fas fa-circle-notch fa-spin"></i> Connecting...
            </div>
        </div>

        <div class="chat-popup-footer">
            <label for="widgetFileInput" class="attach-btn"><i class="fa-solid fa-paperclip"></i></label>
            <input type="file" id="widgetFileInput" style="display: none;" onchange="handleWidgetFile()">
            <input type="text" id="widget-input" class="chat-input" placeholder="Type..." onkeypress="handleWidgetEnter(event)">
            <button class="send-icon-btn" onclick="sendWidgetMessage()"><i class="fa-solid fa-paper-plane"></i></button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let isChatOpen = false;
        let chatInterval = null;

        function checkNotifications() {
            if (isChatOpen) return;
            $.post('chat_engine.php', {
                action: 'get_unread_count'
            }, function(count) {
                const badge = document.getElementById('chat-badge');
                if (parseInt(count) > 0) {
                    badge.innerText = count;
                    badge.classList.add('show');
                } else {
                    badge.classList.remove('show');
                }
            });
        }
        setInterval(checkNotifications, 4000);

        function toggleChat() {
            const win = document.getElementById('chat-popup-window');
            const badge = document.getElementById('chat-badge');
            if (isChatOpen) {
                win.style.display = 'none';
                isChatOpen = false;
                clearInterval(chatInterval);
            } else {
                win.style.display = 'flex';
                isChatOpen = true;
                badge.classList.remove('show');
                loadWidgetMessages();
                chatInterval = setInterval(loadWidgetMessages, 3000);
            }
        }

        function loadWidgetMessages() {
            if (!isChatOpen) return;
            $.post('chat_engine.php', {
                action: 'fetch_chat_user'
            }, function(data) {
                const body = document.getElementById('chat-body');
                const isNearBottom = body.scrollHeight - body.scrollTop - body.clientHeight < 120;

                if (body.innerHTML.length !== data.length || body.innerText.includes("Connecting")) {
                    $('#chat-body').html(data);
                    if (data.trim() === "") $('#chat-body').html('<div style="text-align:center;color:#94a3b8;margin-top:50px;font-size:13px;"><img src="images/Logo4.png" style="width:40px;opacity:0.4;margin-bottom:10px;"><br>Start a conversation.<br>We usually reply in minutes.</div>');
                    $('.user-del-btn i').removeClass('fa-xmark').addClass('fa-trash-can');
                    if (isNearBottom) scrollToWidgetBottom();
                }
            });
        }

        function sendWidgetMessage() {
            let msg = $('#widget-input').val();
            let file = document.getElementById('widgetFileInput').files[0];
            if ((msg.trim() === '' && !file)) return;

            let formData = new FormData();
            formData.append('action', 'send_msg_user');
            formData.append('message', msg);
            if (file) formData.append('attachment', file);

            $('#widget-input').val('');
            $('#widgetFileInput').val('');
            $.ajax({
                url: 'chat_engine.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function() {
                    loadWidgetMessages();
                    setTimeout(scrollToWidgetBottom, 200);
                }
            });
        }

        function deleteMyMessage(id) {
            if (confirm("Are you sure you want to delete this message?")) {
                $.post('chat_engine.php', {
                    action: 'delete_msg_user',
                    message_id: id
                }, function() {
                    loadWidgetMessages();
                });
            }
        }

        function handleWidgetEnter(e) {
            if (e.key === 'Enter') sendWidgetMessage();
        }

        function handleWidgetFile() {
            let file = document.getElementById('widgetFileInput').files[0];
            if (file) {
                $('#widget-input').val("[File: " + file.name + "] ");
                $('#widget-input').focus();
            }
        }

        function scrollToWidgetBottom() {
            const d = document.getElementById('chat-body');
            d.scrollTop = d.scrollHeight;
        }
    </script>
<?php endif; ?>