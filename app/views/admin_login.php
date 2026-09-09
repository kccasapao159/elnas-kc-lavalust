<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
$error = $error ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login · Mindoro State University</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/products.css'); ?>">
</head>
<body>

    <?php include APP_DIR . 'views/_topnav.php'; ?>

    <div class="page-body">
        <div class="panel panel--narrow">
            <h1>Admin Login</h1>
            <p class="subtitle">Sign in to manage product records.</p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="<?= site_url('admin/login'); ?>">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" autocomplete="username" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" autocomplete="current-password" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-full">Log In</button>
                </div>
            </form>
        </div>
    </div>

    <p class="footer-note">Only authenticated admins can access product management.</p>

</body>
</html>
