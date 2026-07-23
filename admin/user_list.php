<?php
session_start();
include '../database/db.php';
include '../includes/header.php';
include '../includes/functions.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['ADMIN','SELLER'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['promote'])) {
    $user_id = (int)$_GET['promote'];
    $sql = "UPDATE users SET role = 'SELLER' WHERE user_id = ? AND role = 'BUYER'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    if (mysqli_stmt_execute($stmt)) {
        $activity = "Promoted user ID $user_id from BUYER to SELLER";
        logActivity($conn, $_SESSION['user_id'], $activity);
    }
}

if (isset($_GET['demote'])) {
    $user_id = (int)$_GET['demote'];
    $sql = "UPDATE users SET role = 'BUYER' WHERE user_id = ? AND role = 'SELLER'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    if (mysqli_stmt_execute($stmt)) {
        $activity = "Demoted user ID $user_id from SELLER to BUYER";
        logActivity($conn, $_SESSION['user_id'], $activity);
    }
}

$sql = "SELECT user_id, username, email, role FROM users WHERE role != 'ADMIN'";
$result = mysqli_query($conn, $sql);
?>
<main class="admin-container seller-list">
    <div class="top-nav">
        <a href="dashboard.php">Return to Dashboard</a>
    </div>

    <h2>Seller Management</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo $row['role']; ?></td>
                <td>
                    <?php if ($row['role'] === 'BUYER'): ?>
                        <a href="seller.php?promote=<?php echo $row['user_id']; ?>"
                           onclick="return confirm('Promote this buyer to seller?');">Promote to Seller</a>
                    <?php elseif ($row['role'] === 'SELLER'): ?>
                        <a href="seller.php?demote=<?php echo $row['user_id']; ?>"
                           onclick="return confirm('Demote this seller back to buyer?');">Demote to Buyer</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</main>

<?php include '../includes/footer.php'; ?>
