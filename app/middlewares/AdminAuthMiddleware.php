<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Protects /products, /products/create, /products/edit/{id} and
 * /products/delete/{id} (Lab 5 requirement): only a logged-in admin
 * (role = 'admin' in the `users` table) may reach these routes.
 */
class AdminAuthMiddleware
{
    public function handle(Closure $next)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION['admin_id'])) {
            return $next();
        }

        $_SESSION['admin_login_error'] = 'Please log in as admin to continue.';
        redirect('admin/login');
    }
}
