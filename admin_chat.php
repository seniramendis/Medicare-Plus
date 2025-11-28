<?php
// admin_chat.php
session_start();
$current_page = 'admin_chat.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    // header("Location: login.php"); exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Chat - Medicare Plus</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            height: 100vh;
            overflow: hidden;
        }

        .main-content {
            margin-left: 260px;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h2 {
            padding: 20px 25px;
            margin: 0;
            color: #1e293b;
            font-size: 24px;
            font-weight: 700;
        }

        .chat-app-container {
            flex: 1;
            display: flex;
            margin: 0 25px 25px 25px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e1e4e8;
        }

        .chat-sidebar {
            width: 320px;
            border-right: 1px solid #eee;
            display: flex;
            flex-direction: column;
            background: #fff;
        }

        .sidebar-header {
            padding: 20px;
            font-size: 18px;
            font-weight: 700;
            color: #111;
            border-bottom: 1px solid #eee;
        }

        /* LIST STYLES */
        .conv-list {
            flex: 1;
            overflow-y: auto;
        }

        .conv-item {
            display: flex;
            align-items: center;
            padding: 15px;
            cursor: pointer;
            transition: background-color 0.2s;
            border-bottom: 1px solid #f9f9f9;
        }

        .conv-item:hover {
            background-color: #f8fafc;
        }

        .conv-item.active-chat {
            background-color: #eff6ff;
            border-right: 4px solid #3b82f6;
        }

        .conv-avatar {
            width: 45px;
            height: 45px;
            background: #3b82f6;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 12px;
            font-size: 16px;
            flex-shrink: 0;
        }

        .conv-info {
            flex: 1;
            overflow: hidden;
        }

        .conv-top {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }

        .conv-name {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .time-ago {
            font-size: 11px;
            color: #94a3b8;
        }

        /* NEW NOTIFICATION STYLES */
        .conv-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 4px;
        }

        .conv-preview {
            font-size: 13px;
            color: #64748b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 85%;
        }

        .unread-badge {
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
            margin-left: 8px;
            flex-shrink: 0;
        }

        /* CHAT AREA STYLES */
        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #fff;
        }

        .chat-header {
            padding: 15px 25px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            background: #fff;
        }

        .header-avatar {
            width: 40px;
            height: 40px;
            background: #ccc;
            border-radius: 50%;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .header-name {
            font-weight: 700;
            font-size: 16px;
            color: #111;
        }

        .messages-box {
            flex: 1;
            padding: 25px;
            overflow-y: auto;
            background-color: #f4f6f8;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message-wrapper {
            display: flex;
            align-items: center;
            max-width: 70%;
            position: relative;
            margin-bottom: 5px;
        }

        .message-bubble {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 14px;
            line-height: 1.5;
            position: relative;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            word-wrap: break-word;
        }

        .chat-img {
            max-width: 200px;
            border-radius: 8px;
            margin-bottom: 5px;
            cursor: pointer;
            display: block;
        }

        .msg-time {
            font-size: 10px;
            opacity: 0.7;
            text-align: right;
            margin-top: 4px;
        }

        .user-msg {
            align-self: flex-start;
        }

        .user-msg .message-bubble {
            background: #fff;
            color: #333;
            border-top-left-radius: 0;
            border: 1px solid #e5e7eb;
        }

        .admin-msg {
            align-self: flex-end;
            flex-direction: row-reverse;
        }

        .admin-msg .message-bubble {
            background: #3b82f6;
            color: white;
            border-top-right-radius: 0;
        }

        .admin-msg .msg-time {
            color: #e0e7ff;
        }

        .delete-btn {
            visibility: hidden;
            cursor: pointer;
            color: #ef4444;
            margin: 0 10px;
            font-size: 12px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .message-wrapper:hover .delete-btn {
            visibility: visible;
        }

        .chat-input-area {
            padding: 20px;
            background: #fff;
            border-top: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .file-upload-label {
            cursor: pointer;
            color: #64748b;
            font-size: 20px;
            padding: 8px;
            border-radius: 50%;
            transition: 0.2s;
        }

        .file-upload-label:hover {
            color: #3b82f6;
            background: #f1f5f9;
        }

        .chat-input {
            flex: 1;
            padding: 14px 20px;
            border: 1px solid #e2e8f0;
            border-radius: 30px;
            outline: none;
            font-family: inherit;
            background: #f8fafc;
        }

        .chat-input:focus {
            border-color: #3b82f6;
            background: #fff;
        }

        .send-btn {
            background: #3b82f6;
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: 0.2s;
        }

        .send-btn:hover {
            background: #2563eb;
            transform: scale(1.05);
        }

        .send-btn:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
            transform: none;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h2>Messages</h2>
        <div class="chat-app-container">
            <div class="chat-sidebar">
                <div class="sidebar-header">Inbox</div>
                <div class="conv-list" id="conversationList">
                    <div style="padding: 20px; text-align: center; color: #94a3b8;">Loading...</div>
                </div>
            </div>

            <div class="chat-area">
                <div class="chat-header">
                    <div class="header-avatar" id="headerAvatar">?</div>
                    <div class="header-name" id="chatHeaderName">Select a conversation</div>
                </div>

                <div class="messages-box" id="adminMsgArea">
                    <div style="text-align:center; margin-top:150px; color:#94a3b8;">
                        <i class="fa-regular fa-comments" style="font-size: 48px; margin-bottom:15px; opacity: 0.5;"></i><br>
                        Select a user from the left to start chatting
                    </div>
                </div>

                <div class="chat-input-area">
                    <input type="hidden" id="activeConvId">
                    <label for="fileInput" class="file-upload-label" title="Attach File"><i class="fa-solid fa-paperclip"></i></label>
                    <input type="file" id="fileInput" style="display: none;" onchange="handleFileSelect()">
                    <input type="text" id="adminReply" class="chat-input" placeholder="Type a message..." disabled>
                    <button class="send-btn" onclick="sendMessage()" id="sendBtn" disabled><i class="fa-solid fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentChatId = null;
        let isHoveringSidebar = false;
        let isHoveringChat = false;

        $(document).ready(function() {
            // Pause Sidebar Refresh
            $('.chat-sidebar').hover(
                function() {
                    isHoveringSidebar = true;
                },
                function() {
                    isHoveringSidebar = false;
                }
            );

            // Pause Chat Refresh
            $('#adminMsgArea').hover(
                function() {
                    isHoveringChat = true;
                },
                function() {
                    isHoveringChat = false;
                }
            );

            loadConversations();
            setInterval(loadConversations, 3000);

            // Auto Refresh Messages (unless hovering)
            setInterval(() => {
                if (!isHoveringChat) {
                    fetchMessages(false);
                }
            }, 2000);

            $('#adminReply').on('keypress', function(e) {
                if (e.which === 13) sendMessage();
            });
        });

        // Load List
        function loadConversations() {
            if (isHoveringSidebar) return;
            $.post('chat_engine.php', {
                action: 'fetch_conversations_admin',
                active_id: currentChatId
            }, function(html) {
                if (html.trim() !== $('#conversationList').html().trim()) {
                    $('#conversationList').html(html);
                }
            });
        }

        // Load Chat
        window.loadAdminChat = function(id) {
            if (currentChatId == id) return;

            currentChatId = id;
            $('#activeConvId').val(id);
            $('#adminReply').prop('disabled', false);
            $('#sendBtn').prop('disabled', false);
            $('#adminReply').focus();

            // HEADER FIX (Clean Name from Data Attribute)
            let clickedItem = $(`.conv-item[onclick*="loadAdminChat(${id})"]`);
            if (clickedItem.length > 0) {
                let cleanName = clickedItem.data('name');
                let initial = clickedItem.data('initial');

                $('#chatHeaderName').text(cleanName);
                $('#headerAvatar').text(initial).css('background', '#3b82f6');

                $('.conv-item').removeClass('active-chat');
                clickedItem.addClass('active-chat');
            }

            $('#adminMsgArea').html('<div style="text-align:center; margin-top:50px; color:#94a3b8;"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');
            fetchMessages(true);
        };

        function fetchMessages(forceScroll = false) {
            if (!currentChatId) return;

            $.post('chat_engine.php', {
                action: 'fetch_chat_admin',
                conversation_id: currentChatId
            }, function(html) {
                let area = $('#adminMsgArea');
                if (area.html() !== html) {
                    let isNearBottom = area[0].scrollHeight - area[0].scrollTop - area[0].clientHeight < 200;
                    area.html(html);
                    if (forceScroll || isNearBottom) {
                        area.scrollTop(area[0].scrollHeight);
                    }
                }
            });
        }

        function sendMessage() {
            let msg = $('#adminReply').val();
            let id = $('#activeConvId').val();
            let fileInput = document.getElementById('fileInput');
            let file = fileInput.files[0];

            if ((msg.trim() === '' && !file) || !id) return;

            let formData = new FormData();
            formData.append('action', 'send_msg_admin');
            formData.append('conversation_id', id);
            formData.append('message', msg);
            if (file) formData.append('attachment', file);

            $('#adminReply').val('');
            $('#fileInput').val('');

            $.ajax({
                url: 'chat_engine.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function() {
                    fetchMessages(true);
                    isHoveringSidebar = false;
                    loadConversations();
                }
            });
        }

        function deleteMessage(msgId) {
            if (confirm("Delete this message?")) {
                $.post('chat_engine.php', {
                    action: 'delete_message',
                    message_id: msgId
                }, function() {
                    fetchMessages(false);
                });
            }
        }

        function handleFileSelect() {
            let file = document.getElementById('fileInput').files[0];
            if (file) {
                $('#adminReply').val("[File: " + file.name + "] ");
                $('#adminReply').focus();
            }
        }
    </script>
</body>

</html>