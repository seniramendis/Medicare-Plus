<?php
session_start();
include 'db_connect.php';

// Check Admin Access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // header("Location: login.php"); 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Appointments Manager | MEDICARE PLUS</title>
    <link rel="icon" href="images/Favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
        }

        .admin-wrapper {
            display: flex;
        }

        .main-content {
            flex: 1;
            padding: 30px;
            margin-left: 280px;
        }

        /* Stats Cards */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .stat-info p {
            margin: 0;
            font-size: 13px;
            color: #888;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* Tabs */
        .tabs {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .tab-btn {
            background: none;
            border: none;
            font-family: 'Poppins';
            font-size: 14px;
            font-weight: 600;
            color: #888;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .tab-btn.active {
            background: #0062cc;
            color: white;
        }

        /* Table */
        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .appt-table {
            width: 100%;
            border-collapse: collapse;
        }

        .appt-table th {
            text-align: left;
            padding: 15px;
            color: #888;
            border-bottom: 2px solid #eee;
            font-size: 13px;
        }

        .appt-table td {
            padding: 15px;
            border-bottom: 1px solid #f5f5f5;
            color: #333;
            font-size: 14px;
        }

        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .bg-blue {
            background: #e3f2fd;
            color: #0062cc;
        }

        .bg-green {
            background: #dcfce7;
            color: #16a34a;
        }

        .bg-orange {
            background: #fff3e0;
            color: #ff9800;
        }

        /* Buttons */
        .btn-add {
            background: #0062cc;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            float: right;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            margin-right: 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-check {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .btn-trash {
            background: #ffebee;
            color: #c62828;
        }

        /* --- MODAL FIX (CENTERED) --- */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Black Background with Opacity */
        }

        .modal-content {
            background-color: white;
            width: 400px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);

            /* THIS CENTERS IT PERFECTLY */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>

    <div class="admin-wrapper">

        <?php include 'sidebar.php'; ?>

        <div class="main-content">

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2 style="margin:0; color:#333;">Appointments Manager</h2>
                <button class="btn-add" onclick="$('#addModal').fadeIn()">+ New Appointment</button>
            </div>

            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-info">
                        <h3 id="count-total">0</h3>
                        <p>Total Records</p>
                    </div>
                    <div class="stat-icon" style="background:#f0f7ff; color:#0062cc;"><i class="fas fa-list"></i></div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3 id="count-pending">0</h3>
                        <p>Pending Request</p>
                    </div>
                    <div class="stat-icon" style="background:#fff3e0; color:#ff9800;"><i class="fas fa-clock"></i></div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3 id="count-confirmed">0</h3>
                        <p>Confirmed</p>
                    </div>
                    <div class="stat-icon" style="background:#e3f2fd; color:#0062cc;"><i class="fas fa-check-circle"></i></div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3 id="count-completed">0</h3>
                        <p>Completed</p>
                    </div>
                    <div class="stat-icon" style="background:#dcfce7; color:#16a34a;"><i class="fas fa-history"></i></div>
                </div>
            </div>

            <div class="tabs">
                <button class="tab-btn active" onclick="filterTab('All', this)">All Appointments</button>
                <button class="tab-btn" onclick="filterTab('Scheduled', this)">Pending / Unconfirmed</button>
                <button class="tab-btn" onclick="filterTab('Confirmed', this)">Confirmed</button>
                <button class="tab-btn" onclick="filterTab('Completed', this)">Completed History</button>
            </div>

            <div class="card">
                <table class="appt-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>PATIENT</th>
                            <th>DOCTOR</th>
                            <th>DATE & TIME</th>
                            <th>REASON</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="addModal" class="modal">
        <div class="modal-content">
            <h3 style="margin-top:0;">Book Appointment</h3>
            <form id="addForm">
                <label>Patient</label>
                <select name="patient_name" class="form-control" required>
                    <?php
                    $p_sql = "SELECT full_name FROM users WHERE role='patient'";
                    $p_res = mysqli_query($conn, $p_sql);
                    if (mysqli_num_rows($p_res) > 0) {
                        while ($r = mysqli_fetch_assoc($p_res)) {
                            echo "<option value='{$r['full_name']}'>{$r['full_name']}</option>";
                        }
                    } else {
                        echo "<option value=''>No Patients Found</option>";
                    }
                    ?>
                </select>

                <label>Doctor</label>
                <select name="doctor_id" class="form-control" required>
                    <?php
                    $d_sql = "SELECT id, full_name FROM users WHERE role='doctor'";
                    $d_res = mysqli_query($conn, $d_sql);
                    while ($r = mysqli_fetch_assoc($d_res)) {
                        echo "<option value='{$r['id']}'>Dr. {$r['full_name']}</option>";
                    }
                    ?>
                </select>

                <label>Date & Time</label>
                <input type="datetime-local" name="date" class="form-control" required>

                <label>Reason</label>
                <input type="text" name="reason" class="form-control" placeholder="e.g. Fever" required>

                <div style="text-align:right; margin-top:10px;">
                    <button type="button" onclick="$('#addModal').fadeOut()" style="padding:10px 15px; border:none; background:#eee; cursor:pointer; border-radius:6px; margin-right:5px;">Cancel</button>
                    <button type="submit" style="background:#0062cc; color:white; padding:10px 20px; border:none; cursor:pointer; border-radius:6px;">Book Now</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let allData = [];
        let currentFilter = 'All';

        $(document).ready(function() {
            fetchData();
            setInterval(fetchData, 4000);

            $('#addForm').submit(function(e) {
                e.preventDefault();
                $.post('admin_appt_api.php', $(this).serialize() + '&action=create', function(response) {
                    if (response.status === 'success') {
                        $('#addModal').fadeOut();
                        $('#addForm')[0].reset();
                        fetchData();
                        alert('Appointment Booked Successfully');
                    } else {
                        alert('Error: ' + (response.message || 'Unknown Error'));
                    }
                }, 'json');
            });
        });

        function fetchData() {
            $.ajax({
                url: 'admin_appt_api.php',
                type: 'POST',
                data: {
                    action: 'fetch'
                },
                dataType: 'json',
                success: function(data) {
                    if (Array.isArray(data)) {
                        allData = data;
                        updateStats();
                        renderTable();
                    } else {
                        console.error("Data error:", data);
                    }
                }
            });
        }

        function updateStats() {
            let pending = allData.filter(d => d.status === 'Scheduled').length;
            let confirmed = allData.filter(d => d.status === 'Confirmed').length;
            let completed = allData.filter(d => d.status === 'Completed').length;

            $('#count-total').text(allData.length);
            $('#count-pending').text(pending);
            $('#count-confirmed').text(confirmed);
            $('#count-completed').text(completed);
        }

        function filterTab(status, btn) {
            currentFilter = status;
            $('.tab-btn').removeClass('active');
            $(btn).addClass('active');
            renderTable();
        }

        function renderTable() {
            let filteredData = allData;

            if (currentFilter !== 'All') {
                filteredData = allData.filter(d => d.status === currentFilter);
            }

            let rows = '';
            if (filteredData.length === 0) {
                rows = '<tr><td colspan="7" style="text-align:center; padding:30px; color:#999;">No records found in this section.</td></tr>';
            } else {
                filteredData.forEach(item => {
                    let badge = 'bg-orange';
                    if (item.status === 'Confirmed') badge = 'bg-blue';
                    if (item.status === 'Completed') badge = 'bg-green';

                    let actionBtns = '';
                    if (item.status === 'Scheduled') {
                        actionBtns = `<button class="btn-icon btn-check" title="Confirm" onclick="setStatus(${item.id}, 'Confirmed')"><i class="fas fa-check"></i></button>`;
                    } else if (item.status === 'Confirmed') {
                        actionBtns = `<button class="btn-icon btn-check" style="background:#0062cc; color:white;" title="Mark Complete" onclick="setStatus(${item.id}, 'Completed')"><i class="fas fa-clipboard-check"></i></button>`;
                    }
                    actionBtns += `<button class="btn-icon btn-trash" onclick="deleteItem(${item.id})"><i class="fas fa-trash"></i></button>`;

                    rows += `
                <tr>
                    <td>#${item.id}</td>
                    <td><b>${item.patient_name}</b></td>
                    <td>Dr. ${item.doctor_name}</td>
                    <td>${item.appointment_time}</td>
                    <td>${item.reason}</td>
                    <td><span class="badge ${badge}">${item.status}</span></td>
                    <td>${actionBtns}</td>
                </tr>`;
                });
            }
            $('#tableBody').html(rows);
        }

        function setStatus(id, status) {
            $.post('admin_appt_api.php', {
                action: 'update_status',
                id: id,
                status: status
            }, function(res) {
                if (res.status === 'success') fetchData();
            }, 'json');
        }

        function deleteItem(id) {
            if (confirm('Delete this record?')) {
                $.post('admin_appt_api.php', {
                    action: 'delete',
                    id: id
                }, function(res) {
                    if (res.status === 'success') fetchData();
                }, 'json');
            }
        }
    </script>

</body>

</html>