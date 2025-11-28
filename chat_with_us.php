<?php
$pageTitle = 'Chat With Us';
include 'db_connect.php';
// Session start is usually in header, but ensuring it here just in case
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Username Logic
$userName = "Guest";
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    $parts = explode(' ', $_SESSION['username']);
    $userName = $parts[0];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat With Us - Medicare Plus</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
    <style>
        /* --- KEEPING YOUR EXISTING CSS VARIABLES --- */
        :root {
            --primary-blue: #1e3a8a;
            --primary-green: #57c95a;
            --bg-light: #f4f7f6;
            --bg-white: #ffffff;
        }

        body {
            margin: 0;
            font-family: sans-serif;
            background-color: var(--bg-light);
        }

        .page-container {
            width: 85%;
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background: var(--bg-white);
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .chat-intro-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .chat-intro-section h2 {
            color: var(--primary-blue);
            border-bottom: 3px solid var(--primary-green);
            display: inline-block;
            padding-bottom: 10px;
        }

        /* --- NEW CHAT UI --- */
        .chat-embed-area {
            height: 500px;
            border: 1px solid #ddd;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: #fff;
        }

        .chat-messages-window {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #f9f9f9;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .chat-input-area {
            padding: 15px;
            background: #fff;
            border-top: 1px solid #eee;
            display: flex;
            gap: 10px;
        }

        .chat-input-field {
            flex: 1;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 25px;
            outline: none;
        }

        .send-btn {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
        }

        .send-btn:hover {
            background: #162c6b;
        }

        /* MESSAGE BUBBLES */
        .message {
            max-width: 75%;
            padding: 10px 15px;
            border-radius: 15px;
            font-size: 14px;
            line-height: 1.4;
            word-wrap: break-word;
        }

        .user-msg {
            background: var(--primary-blue);
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 2px;
        }

        .admin-msg {
            background: #e0e0e0;
            color: #333;
            align-self: flex-start;
            border-bottom-left-radius: 2px;
        }
    </style>
</head>

<body>

    <?php if (file_exists('header.php')) include 'header.php'; ?>

    <main class="page-container">
        <section class="chat-intro-section">
            <h2><i class="fa-solid fa-comment-dots"></i> Live Support</h2>
            <p>Hello, <?php echo htmlspecialchars($userName); ?>! Our team is online.</p>
        </section>

        <div class="chat-embed-area">
            <!-- Messages load here -->
            <div class="chat-messages-window" id="message-display">
                <p style="text-align:center; color:#999; margin-top:50px;">
                    <i class="fas fa-spinner fa-spin"></i> Connecting to chat server...
                </p>
            </div>

            <!-- Input Area -->
            <div class="chat-input-area">
                <input type="text" id="chat-input" class="chat-input-field" placeholder="Type your message..." onkeypress="handleEnter(event)">
                <button class="send-btn" onclick="sendMessage()"><i class="fa-solid fa-paper-plane"></i></button>
            </div>
        </div>
    </main>

    <?php if (file_exists('footer.php')) include 'footer.php'; ?>

    <!-- AJAX LOGIC -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // 1. Load messages on start
        $(document).ready(function() {
            loadMessages();
            // Scroll to bottom after short delay
            setTimeout(scrollToBottom, 500);
        });

        // 2. Fetch Messages Function
        function loadMessages() {
            $.post('chat_engine.php', {
                action: 'fetch_chat_user'
            }, function(data) {
                // Only scroll if we are near bottom or it's first load
                const display = document.getElementById('message-display');
                const isNearBottom = display.scrollHeight - display.scrollTop - display.clientHeight < 100;

                $('#message-display').html(data);

                if (data.trim() === "") {
                    $('#message-display').html('<p style="text-align:center; color:#bbb; margin-top:40px;">No messages yet. Say hello!</p>');
                } else if (isNearBottom) {
                    scrollToBottom();
                }
            });
        }

        // 3. Send Message Function
        function sendMessage() {
            const msg = $('#chat-input').val();
            if (msg.trim() === '') return;

            // Optimistic UI: Add message immediately before server confirms (optional, but makes it feel faster)
            // For now, we wait for reload to keep it simple.

            $.post('chat_engine.php', {
                action: 'send_msg_user',
                message: msg
            }, function(response) {
                $('#chat-input').val('');
                loadMessages();
                setTimeout(scrollToBottom, 200);
            });
        }

        function handleEnter(e) {
            if (e.key === 'Enter') sendMessage();
        }

        function scrollToBottom() {
            const d = document.getElementById('message-display');
            d.scrollTop = d.scrollHeight;
        }

        // 4. Auto Refresh every 3 seconds
        setInterval(loadMessages, 3000);
    </script>
</body>

</html>