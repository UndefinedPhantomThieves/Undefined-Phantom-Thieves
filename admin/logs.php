<?php
session_start();
include '../database/db.php';
include '../includes/header.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['ADMIN','SELLER'])) {
    header("Location: ../login.php");
    exit;
}

$sqlLogs = "SELECT l.log_id, u.username, l.activity, l.created_at
            FROM audit_logs l
            JOIN users u ON l.user_id = u.user_id
            ORDER BY l.created_at DESC";
$logs = mysqli_query($conn, $sqlLogs);
?>

<main class="admin-container logs">
    <div class="top-nav">
        <a href="dashboard.php">Return to Dashboard</a>
    </div>

    <h2>Activity Logs</h2>
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
