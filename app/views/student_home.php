<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Home</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/student.css'); ?>">
</head>
<body>

    <div class="card card--home">

        <span class="id-eyebrow">Mindoro State University<span class="dot">&middot;</span>Calapan City Campus</span>

        <div class="id-seal" title="MinSU Verified Student">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M9 16.2l-3.5-3.5-1.4 1.4L9 19 20 8l-1.4-1.4z"/>
            </svg>
        </div>

        <h1>Welcome back, <span class="accent">Student.</span></h1>
        <p class="lead">
            This is your student information page &mdash; view your record and manage your profile anytime.
        </p>

        <div class="id-perf"></div>

        <nav class="id-actions">
            <a href="<?= site_url('student/profile'); ?>" class="btn-primary">
                View My Profile
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <a href="<?= site_url('users'); ?>" class="btn-secondary">
                View All Users
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h13M13 6l6 6-6 6"/></svg>
            </a>
            <a href="<?= site_url('/'); ?>" class="btn-ghost">Home</a>
        </nav>

    </div>

</body>
</html>