<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$is_admin = !empty($_SESSION['admin_id']);
?>
<header class="site-header">
    <a href="<?= site_url('/'); ?>" class="brand">
        <img src="https://minsu.edu.ph/template/images/logo.png" alt="MinSU Logo" class="brand-logo">
        <span class="brand-text">
            <strong>Mindoro State University</strong>
            <span>Calapan City Campus</span>
        </span>
    </a>

    <nav class="top-nav">
        <?php if ($is_admin): ?>
            <a href="<?= site_url('products'); ?>">View Records</a>
            <a href="<?= site_url('admin/profile'); ?>">Profile</a>
            <span class="admin-pill">Admin: <?= htmlspecialchars($_SESSION['admin_username'] ?? 'admin'); ?></span>
            <a href="<?= site_url('admin/logout'); ?>" class="btn-admin-login">Logout</a>
        <?php else: ?>
            <a href="<?= site_url('admin/login'); ?>" class="btn-admin-login">Login as Admin</a>
        <?php endif; ?>
    </nav>
</header>
