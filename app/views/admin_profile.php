<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
$username = $username ?? '';
$email    = $email ?? '';
$role     = $role ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile · Mindoro State University</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/products.css'); ?>">
</head>
<body>

    <?php include APP_DIR . 'views/_topnav.php'; ?>

    <div class="page-body">
        <div class="panel panel--narrow">
            <h1>Admin Profile</h1>
            <p class="subtitle">Your account details.</p>

            <div class="form-group">
                <label>Username</label>
                <input type="text" value="<?= htmlspecialchars($username); ?>" disabled>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" value="<?= htmlspecialchars($email); ?>" disabled>
            </div>
            <div class="form-group">
                <label>Role</label>
                <input type="text" value="<?= htmlspecialchars($role); ?>" disabled>
            </div>

            <div class="form-actions">
                <a href="<?= site_url('products'); ?>" class="btn btn-ghost">Back to Products</a>
            </div>
        </div>
    </div>

</body>
</html>
