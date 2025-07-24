<?php
require_once '../backend_control/conn.php';
$message = '';
$token = $_GET['token'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $newPassword = $_POST['password'];

    if (strlen($newPassword) < 6) {
        $message = '<div class="alert alert-danger">❌ Password must be at least 6 characters.</div>';
    } else {
        $stmt = $conn->prepare("SELECT email, expires_at FROM password_resets WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (strtotime($row['expires_at']) < time()) {
                $message = '<div class="alert alert-danger">⏰ Token expired.</div>';
            } else {
                $email = $row['email'];
                $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

                $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
                $update->bind_param("ss", $hashed, $email);
                $update->execute();

                $del = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
                $del->bind_param("s", $email);
                $del->execute();

                $message = '<div class="alert alert-success">✅ Password reset successful. <a href="../public/index.php">Login now</a></div>';
            }
        } else {
            $message = '<div class="alert alert-danger">❌ Invalid token.</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <h2 class="mb-4">🔒 Reset Password</h2>

    <?= $message ?>

    <?php if (empty($message) || str_contains($message, '❌') || str_contains($message, '⏰')): ?>
        <form method="POST" class="card p-4 shadow-sm">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <div class="mb-3">
                <label for="password" class="form-label">New Password:</label>
                <input type="password" class="form-control" name="password" id="password" required minlength="6">
            </div>

            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
    <?php endif; ?>

</body>
</html>
