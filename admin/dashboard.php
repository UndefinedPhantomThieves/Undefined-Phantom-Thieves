<?php
session_start();
include '../database/db.php';
include '../includes/header.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['ADMIN','SELLER'])) {
    header("Location: ../login.php");
    exit;
}

$totalProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM inventory"))['count'];
$totalSellers  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users WHERE role='SELLER'"))['count'];

$sqlLogs = "SELECT l.log_id, u.username, l.activity, l.created_at
            FROM audit_logs l
            JOIN users u ON l.user_id = u.user_id
            ORDER BY l.created_at DESC
            LIMIT 5";
$logs = mysqli_query($conn, $sqlLogs);
?>

<main class="admin-container dashboard">
    <h2>Admin Dashboard</h2>

    <div class="stats">
        <div class="stat-card">
            <h3>Total Products</h3>
            <p><?php echo $totalProducts; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Sellers</h3>
            <p><?php echo $totalSellers; ?></p>
        </div>
    </div>

    <div class="buttons">
        <a href="inventory.php">Manage Products</a><br>
        <a href="user_list.php">Manage Users</a>
    </div>

    <h3>Recent Activity Logs</h3>
    <a href="logs.php">View Full Logs</a><br><br>
    <table>
        <tr>
            <th>Username</th><th>Activity</th><th>Time</th>
        </tr>
        <?php while ($log = mysqli_fetch_assoc($logs)): ?>
            <tr>
                <td><?php echo htmlspecialchars($log['username']); ?></td>
                <td><?php echo htmlspecialchars($log['activity']); ?></td>
                <td><?php echo $log['created_at']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</main>

<?php include '../includes/footer.php'; ?>
