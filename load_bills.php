<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    exit();
}

$patient_name = $_SESSION['username'];

// 1. Get Patient ID based on the logged-in username
$u_sql = "SELECT id FROM users WHERE full_name = '$patient_name'";
$u_res = mysqli_query($conn, $u_sql);

if (mysqli_num_rows($u_res) > 0) {
    $patient_id = mysqli_fetch_assoc($u_res)['id'];
} else {
    echo "Error: User not found.";
    exit();
}

// 2. Calculate Total Due Amount
$due_sql = "SELECT SUM(amount) as total FROM invoices WHERE patient_id = '$patient_id' AND status = 'unpaid'";
$due_res = mysqli_fetch_assoc(mysqli_query($conn, $due_sql));
$total_due = $due_res['total'] ? $due_res['total'] : 0.00;

// 3. Fetch List of Unpaid Bills
$bill_sql = "SELECT * FROM invoices WHERE patient_id = '$patient_id' AND status = 'unpaid' ORDER BY id DESC";
$bill_res = mysqli_query($conn, $bill_sql);
?>

<!-- HTML Output starts here -->
<h4 style="margin:0; color:#555;">Outstanding Due</h4>
<div class="total-due">LKR <?php echo number_format($total_due, 2); ?></div>

<table class="pay-table">
    <tr>
        <th>Service</th>
        <th>Amount</th>
        <th>Action</th>
    </tr>

    <?php if (mysqli_num_rows($bill_res) > 0): ?>
        <?php while ($bill = mysqli_fetch_assoc($bill_res)): ?>
            <tr>
                <td>
                    <?php echo htmlspecialchars($bill['service_name']); ?>

                    <!-- Edited Badge Logic -->
                    <?php if (isset($bill['is_edited']) && $bill['is_edited'] == 1): ?>
                        <span style="background: #ffc107; color: #333; font-size: 10px; padding: 2px 6px; border-radius: 4px; font-weight: bold; margin-left: 5px;">EDITED</span>
                    <?php endif; ?>
                </td>

                <td><?php echo number_format($bill['amount'], 2); ?></td>

                <td>
                    <!-- IMPORTANT: This form sends data to the Payment Page -->
                    <form action="payment.php" method="POST">
                        <input type="hidden" name="invoice_id" value="<?php echo $bill['id']; ?>">
                        <input type="hidden" name="amount" value="<?php echo $bill['amount']; ?>">
                        <input type="hidden" name="service_name" value="<?php echo htmlspecialchars($bill['service_name']); ?>">

                        <button type="submit" class="btn-pay" style="padding: 5px 10px; font-size: 12px;">Pay Now</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>

    <?php else: ?>
        <tr>
            <td colspan="3" style="color:#28a745; padding:15px 0; font-weight:500;">
                <i class="fas fa-check-circle"></i> No pending bills!
            </td>
        </tr>
    <?php endif; ?>
</table>