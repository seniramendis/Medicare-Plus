<?php
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
        /* --- RESET --- */
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

        /* --- CONTAINER --- */
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

        /* --- SIDEBAR --- */
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

        /* SEARCH */
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

        /* CONTACTS */
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

        /* --- CHAT AREA --- */
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

        .msg {
            display: flex;
            width: 100%;
            align-items: flex-end;
        }

        .msg.sent {
            justify-content: flex-end;
        }

        /* DELETE BUTTON STYLES */
        .delete-btn {
            opacity: 0;
            /* Hidden by default */
            color: #ef4444;
            cursor: pointer;
            margin: 0 10px;
            font-size: 14px;
            transition: opacity 0.2s;
            padding: 5px;
        }

        /* Show delete button when hovering over the message row */
        .msg:hover .delete-btn {
            opacity: 1;
        }

        .bubble {
            max-width: 70%;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 15px;
            line-height: 1.5;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .bubble.sent {
            background: #3b82f6;
            color: white;
            border-radius: 12px 12px 2px 12px;
        }

        .bubble.received {
            background: white;
            color: #111827;
            border: 1px solid #e5e7eb;
            border-radius: 12px 12px 12px 2px;
        }

        /* INPUT */
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
                <li style="padding:20px; text-align:center; color:#6b7280;">Loading...</li>
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

                        <button type="button" class="btn-attach" onclick="$('#fileInput').click()" title="Add File">
                            <i class="fas fa-paperclip"></i>
                        </button>

                        <input type="text" id="msgInput" class="input-text" placeholder="Type a message..." autocomplete="off">

                        <button type="submit" class="btn-send">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        let currentChatId = null;
        let isSearching = false;

        $(document).ready(function() {
            loadContacts();

            $('#contactSearch').on('input', function() {
                var value = $(this).val().toLowerCase();
                isSearching = (value.length > 0);
                $("#contactsList li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            setInterval(() => {
                if (!isSearching) loadContacts();
            }, 5000);
            setInterval(() => {
                if (currentChatId) loadMessages(currentChatId, false);
            }, 3000);
        });

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

                let html = '';
                if (!data.length) {
                    $('#contactsList').html('<li style="padding:15px; text-align:center; color:#6b7280;">No contacts</li>');
                    return;
                }

                data.forEach(u => {
                    let active = (currentChatId == u.id) ? 'active' : '';
                    let initial = u.full_name ? u.full_name.charAt(0).toUpperCase() : '?';
                    let badge = u.unread_count > 0 ? `<span style="background:#ef4444; color:white; padding:2px 8px; border-radius:10px; font-size:11px;">${u.unread_count}</span>` : '';

                    html += `
                    <li class="contact-card ${active}" id="contact-${u.id}" onclick="openChat(${u.id}, '${u.full_name}')">
                        <div class="avatar">${initial}</div>
                        <div class="info">
                            <div class="name">${u.full_name}</div>
                            <div class="role">${u.role}</div>
                        </div>
                        ${badge}
                    </li>`;
                });
                $('#contactsList').html(html);
            }, 'json');
        }

        function openChat(id, name) {
            currentChatId = id;
            $('.contact-card').removeClass('active');
            $(`#contact-${id}`).addClass('active');

            $('#noChat').hide();
            $('#activeChat').css('display', 'flex');
            $('#headerName').text(name);
            $('#headerAvatar').text(name.charAt(0).toUpperCase());
            loadMessages(id, true);
        }

        function loadMessages(id, scroll) {
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

                        // Add Delete Icon for My Messages
                        let deleteIcon = '';
                        if (isMe) {
                            deleteIcon = `<i class="fas fa-trash delete-btn" onclick="deleteMsg(${msg.id})" title="Delete Message"></i>`;
                        }

                        html += `
                        <div class="msg ${cls}">
                            ${deleteIcon}
                            <div class="bubble ${cls}">
                                ${content}
                                <div style="font-size:11px; opacity:0.8; text-align:right; margin-top:5px;">${msg.timestamp.split(' ')[1].substr(0,5)}</div>
                            </div>
                        </div>`;
                    });
                }
                $('#messagesBox').html(html);
                if (scroll) document.getElementById("messagesBox").scrollTop = 99999;
            }, 'json');
        }

        function sendMessage(e) {
            e.preventDefault();
            let txt = $('#msgInput').val();
            let file = $('#fileInput')[0].files[0];
            if (!txt.trim() && !file && txt.indexOf('File:') === -1) return;

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

        function deleteMsg(id) {
            if (confirm("Are you sure you want to delete this message?")) {
                $.post('message_api.php', {
                    action: 'delete_message',
                    msg_id: id
                }, function(response) {
                    loadMessages(currentChatId, false);
                });
            }
        }
    </script>
</body>

</html>