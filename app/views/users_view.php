<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * @var array $users  List of user records returned by UserModel::all()
 */
$users = $users ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users · Mindoro State University</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/users.css'); ?>">
</head>
<body class="users-body">

    <header class="users-header">
        <div class="users-header-inner">
            <p class="users-kicker">Student Information Portal</p>
            <h1>Registered Users</h1>
            <p class="users-subtitle">Mindoro State University &middot; Calapan City Campus</p>
        </div>
    </header>

    <main class="users-container">
        <div class="users-toolbar">
            <a href="<?= site_url('/'); ?>" class="users-back-link">&larr; Back to Home</a>
        </div>

        <div class="users-card">
            <?php if (!empty($users)): ?>
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Username</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><span class="users-id-badge"><?= $user['id']; ?></span></td>
                            <td><?= $user['firstname']; ?></td>
                            <td><?= $user['lastname']; ?></td>
                            <td><?= $user['email']; ?></td>
                            <td><span class="users-username">@<?= $user['username']; ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="users-empty">No users found.</div>
            <?php endif; ?>
        </div>

        <p class="users-footer-note">Total users: <?= count($users); ?></p>
    </main>

</body>
</html>