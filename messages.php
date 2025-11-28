<?php
// messages.php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$my_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Messages | Medicare Plus</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* [KEEP YOUR EXISTING CSS] */
        * {
            box-sizing: border-box;
            outline: none;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            overflow: hidden;
            padding-top: 0 !important;
        }

        .app-window {
            width: 95%;
            max-width: 1600px;
            height: calc(100vh - 90px);
            margin: 85px auto 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            overflow: hidden;
            border: 1px solid #d1d5db;
        }

        .sidebar {
            width: 350px;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            background: #ffffff;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #f3f4f6;
        }

        .sidebar-header h2 {
            margin: 0 0 15px 0;
            font-size: 22px;
            color: #111827;
        }

        .search-container {
            position: relative;
        }

        .search-container input {
            width: 100%;
            padding: 12px 15px 12px 40px;
            background: #f9fafb;
            border: 2px solid #d1d5db;
            border-radius: 8px;
            color: #000000;
            font-size: 14px;
        }

        .search-container i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }

        .contact-list {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
            list-style: none;
            margin: 0;
        }

        .contact-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            margin-bottom: 5px;
            border-radius: 8px;
            cursor: pointer;
            border: 1px solid transparent;
            background: #ffffff;
            position: relative;
        }

        .contact-card:hover {
            background-color: #f3f4f6;
        }

        .contact-card.active {
            background-color: #e5e7eb !important;
            border: 1px solid #d1d5db;
        }

        .avatar {
            width: 45px;
            height: 45px;
            background: #3b82f6;
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }

        .avatar.admin-avatar {
            background: #1e3a8a;
        }

        .info {
            flex: 1;
            overflow: hidden;
        }

        .name {
            font-weight: 700;
            color: #000000 !important;
            font-size: 15px;
            margin-bottom: 3px;
        }

        .role {
            font-size: 13px;
            color: #4b5563 !important;
        }

        .badge-count {
            background: #ef4444;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: bold;
            display: none;
        }

        .badge-count.show {
            display: inline-block;
        }

        .chat-area {
            flex: 1;
            background: #f9fafb;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 15px 25px;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 15px;
            height: 70px;
        }

        .chat-header h3 {
            margin: 0;
            color: #111827;
        }

        .messages {
            flex: 1;
            overflow-y: auto;
            padding: 25px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Unified Message Styles (Handles both chat_engine and internal) */
        .msg,
        .message-wrapper {
            display: flex;
            width: 100%;
            align-items: flex-end;
            margin-bottom: 10px;
        }

        .bubble,
        .message-bubble {
            max-width: 70%;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 15px;
            line-height: 1.5;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* My Messages (Right) */
        .msg.sent,
        .user-msg {
            justify-content: flex-end;
        }

        .bubble.sent,
        .user-msg .message-bubble {
            background: #3b82f6;
            color: white;
            border-radius: 12px 12px 2px 12px;
        }

        /* Their Messages (Left) */
        .msg.received,
        .admin-msg {
            justify-content: flex-start;
        }

        .bubble.received,
        .admin-msg .message-bubble {
            background: white;
            color: #111827;
            border: 1px solid #e5e7eb;
            border-radius: 12px 12px 12px 2px;
        }

        .msg-time {
            font-size: 11px;
            opacity: 0.7;
            text-align: right;
            margin-top: 4px;
            display: block;
        }

        .chat-img {
            max-width: 200px;
            border-radius: 8px;
            margin-top: 5px;
            cursor: pointer;
        }

        .delete-btn {
            opacity: 0;
            color: #ef4444;
            cursor: pointer;
            margin: 0 12px;
            font-size: 14px;
            transition: opacity 0.2s;
            padding: 5px;
        }

        .msg:hover .delete-btn,
        .message-wrapper:hover .delete-btn {
            opacity: 1;
        }

        .input-area {
            padding: 20px;
            background: white;
            border-top: 1px solid #e5e7eb;
        }

        .input-form {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-attach {
            width: 45px;
            height: 45px;
            background: #e5e7eb;
            color: #374151;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .btn-attach:hover {
            background: #d1d5db;
        }

        .input-text {
            flex: 1;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            background: #f9fafb;
        }

        .input-text:focus {
            border-color: #3b82f6;
            background: white;
        }

        .btn-send {
            width: 50px;
            height: 45px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-send:hover {
            background: #2563eb;
        }

        .empty {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="app-window">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Messages</h2>
                <div class="search-container">
                    <i class="fas fa-search"></i>
                    <input type="text" id="contactSearch" placeholder="Search...">
                </div>
            </div>
            <ul class="contact-list" id="contactsList">
                <li class="contact-card" id="contact-admin" onclick="openChat('admin', 'Admin Support')">
                    <div class="avatar admin-avatar"><i class="fas fa-headset"></i></div>
                    <div class="info">
                        <div class="name">Admin Support</div>
                        <div class="role">Hospital Administration</div>
                    </div>
                    <span class="badge-count" id="admin-badge">0</span>
                </li>
            </ul>
        </aside>

        <main class="chat-area">
            <div id="noChat" class="empty">
                <h3>Select a conversation</h3>
            </div>
            <div id="activeChat" style="display:none; flex-direction:column; height:100%;">
                <div class="chat-header">
                    <div class="avatar" id="headerAvatar">?</div>
                    <div>
                        <h3 id="headerName">User</h3>
                    </div>
                </div>
                <div class="messages" id="messagesBox"></div>
                <div class="input-area">
                    <form class="input-form" onsubmit="sendMessage(event)">
                        <input type="file" id="fileInput" hidden onchange="handleFileSelect()">
                        <button type="button" class="btn-attach" onclick="$('#fileInput').click()" title="Add File"><i class="fas fa-paperclip"></i></button>
                        <input type="text" id="msgInput" class="input-text" placeholder="Type a message..." autocomplete="off">
                        <button type="submit" class="btn-send"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        let currentChatId = null;
        let isSearching = false;
        let isHoveringMessages = false; // HOVER FIX

        $(document).ready(function() {
            loadContacts();
            updateAdminBadge();

            // Hover Logic for Messages Area
            $('#messagesBox').hover(
                function() {
                    isHoveringMessages = true;
                },
                function() {
                    isHoveringMessages = false;
                }
            );

            $('#contactSearch').on('input', function() {
                var value = $(this).val().toLowerCase();
                isSearching = (value.length > 0);
                $("#contactsList li:not(#contact-admin)").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            setInterval(() => {
                if (!isSearching) loadContacts();
            }, 5000);
            setInterval(updateAdminBadge, 4000);

            // Modified Interval: Only load if NOT hovering
            setInterval(() => {
                if (currentChatId && !isHoveringMessages) {
                    loadMessages(currentChatId, false);
                }
            }, 3000);
        });

        function updateAdminBadge() {
            if (currentChatId === 'admin') return;
            $.post('chat_engine.php', {
                action: 'get_unread_count'
            }, function(count) {
                if (parseInt(count) > 0) $('#admin-badge').text(count).addClass('show');
                else $('#admin-badge').removeClass('show');
            });
        }

        function handleFileSelect() {
            const file = $('#fileInput')[0].files[0];
            if (file) $('#msgInput').val('File: ' + file.name).focus();
        }

        function loadContacts() {
            if ($('#contactSearch').is(':focus') || isSearching) return;
            $.post('message_api.php', {
                action: 'get_contacts'
            }, function(data) {
                if (!data || data.error) return;
                try {
                    if (typeof data === 'string') data = JSON.parse(data);
                } catch (e) {}
                $('#contactsList li').not('#contact-admin').remove();
                let html = '';
                if (data.length) {
                    data.forEach(u => {
                        if (u.role === 'Admin') return;
                        let active = (currentChatId == u.id) ? 'active' : '';
                        let initial = u.full_name ? u.full_name.charAt(0).toUpperCase() : '?';
                        let badgeClass = u.unread_count > 0 ? 'show' : '';
                        html += `<li class="contact-card ${active}" id="contact-${u.id}" onclick="openChat(${u.id}, '${u.full_name}')">
                                    <div class="avatar">${initial}</div>
                                    <div class="info"><div class="name">${u.full_name}</div><div class="role">${u.role}</div></div>
                                    <span class="badge-count ${badgeClass}">${u.unread_count}</span>
                                </li>`;
                    });
                    $('#contactsList').append(html);
                }
            }, 'json');
        }

        function openChat(id, name) {
            currentChatId = id;
            $('.contact-card').removeClass('active');
            if (id === 'admin') {
                $('#contact-admin').addClass('active');
                $('#headerAvatar').html('<i class="fas fa-headset"></i>').css('background', '#1e3a8a');
                $('#admin-badge').removeClass('show');
            } else {
                $(`#contact-${id}`).addClass('active');
                $('#headerAvatar').text(name.charAt(0).toUpperCase()).css('background', '#3b82f6');
            }
            $('#noChat').hide();
            $('#activeChat').css('display', 'flex');
            $('#headerName').text(name);
            loadMessages(id, true);
        }

        function loadMessages(id, scroll) {
            let box = document.getElementById('messagesBox');
            let isBottom = box.scrollHeight - box.scrollTop - box.clientHeight < 150;

            // === ADMIN CHAT (via chat_engine.php) ===
            if (id === 'admin') {
                $.post('chat_engine.php', {
                    action: 'fetch_chat_user'
                }, function(data) {
                    if ($('#messagesBox').html() !== data) {
                        $('#messagesBox').html(data);
                        if (scroll || isBottom) box.scrollTop = box.scrollHeight;
                    }
                });
                return;
            }

            // === INTERNAL CHAT (via message_api.php) ===
            $.post('message_api.php', {
                action: 'get_messages',
                other_id: id
            }, function(data) {
                let html = '';
                try {
                    if (typeof data === 'string') data = JSON.parse(data);
                } catch (e) {}
                if (!data || !data.length) html = '<div style="text-align:center; margin-top:50px; color:#9ca3af;">No messages.</div>';
                else {
                    data.forEach(msg => {
                        let isMe = msg.is_me;
                        let cls = isMe ? 'sent' : 'received';
                        let content = msg.message;
                        if (msg.attachment) content = `<b>[Attachment]</b><br><a href="uploads/${msg.attachment}" target="_blank" style="color:inherit;">View File</a><br>${content}`;
                        let deleteIcon = isMe ? `<i class="fas fa-trash delete-btn" onclick="deleteMsg(${msg.id}, 'internal')" title="Delete"></i>` : '';
                        html += `<div class="msg ${cls}">
                                    ${deleteIcon}
                                    <div class="bubble ${cls}">
                                        ${content}
                                        <span class="msg-time">${msg.timestamp ? msg.timestamp.split(' ')[1].substr(0,5) : ''}</span>
                                    </div>
                                </div>`;
                    });
                }
                $('#messagesBox').html(html);
                if (scroll || isBottom) box.scrollTop = box.scrollHeight;
            }, 'json');
        }

        function sendMessage(e) {
            e.preventDefault();
            let txt = $('#msgInput').val();
            let file = $('#fileInput')[0].files[0];
            if (!txt.trim() && !file && txt.indexOf('File:') === -1) return;

            if (currentChatId === 'admin') {
                if (txt.indexOf('File:') !== -1) txt = '';
                let fd = new FormData();
                fd.append('action', 'send_msg_user');
                fd.append('message', txt);
                if (file) fd.append('attachment', file);
                $('#msgInput').val('');
                $('#fileInput').val('');
                $.ajax({
                    url: 'chat_engine.php',
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function() {
                        loadMessages('admin', true);
                    }
                });
                return;
            }

            if (txt.indexOf('File:') !== -1) txt = '';
            let fd = new FormData();
            fd.append('action', 'send');
            fd.append('receiver_id', currentChatId);
            fd.append('message', txt);
            if (file) fd.append('attachment', file);
            $('#msgInput').val('');
            $('#fileInput').val('');
            $.ajax({
                url: 'message_api.php',
                type: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                success: function() {
                    loadMessages(currentChatId, true);
                }
            });
        }

        function deleteMsg(id, type) {
            if (confirm("Are you sure?")) {
                let url = (type === 'internal') ? 'message_api.php' : 'chat_engine.php';
                let action = (type === 'internal') ? 'delete_message' : 'delete_msg_user';
                let idKey = (type === 'internal') ? 'msg_id' : 'message_id';
                $.post(url, {
                    action: action,
                    [idKey]: id
                }, function() {
                    loadMessages(currentChatId, false);
                });
            }
        }

        // This links to the onclick event generated by chat_engine.php
        function deleteMyMessage(id) {
            deleteMsg(id, 'admin');
        }
    </script>
</body>

</html>