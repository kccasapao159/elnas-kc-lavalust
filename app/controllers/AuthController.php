<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: AuthController
 *
 * Admin login / logout / profile for the Lab 5 Product CRUD module.
 * Authenticates against the existing `users` table, requiring
 * role = 'admin' and is_active = 1.
 */
class AuthController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->call->model('UserModel');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * GET /admin/login
     */
    public function loginForm()
    {
        // Already logged in? Skip straight to the product list.
        if (!empty($_SESSION['admin_id'])) {
            redirect('products');
            return;
        }

        $data['error'] = $_SESSION['admin_login_error'] ?? null;
        unset($_SESSION['admin_login_error']);
        $this->call->view('admin_login', $data);
    }

    /**
     * POST /admin/login
     */
    public function login()
    {
        $username = trim($_POST['username'] ?? '');
        $password = (string) ($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $_SESSION['admin_login_error'] = 'Username and password are required.';
            redirect('admin/login');
            return;
        }

        $user = $this->UserModel->find_by('username', $username);

        if (empty($user) || empty($user['password']) || !password_verify($password, $user['password'])) {
            $_SESSION['admin_login_error'] = 'Invalid username or password.';
            redirect('admin/login');
            return;
        }

        if ($user['role'] !== 'admin') {
            $_SESSION['admin_login_error'] = 'This account does not have admin access.';
            redirect('admin/login');
            return;
        }

        if (empty($user['is_active'])) {
            $_SESSION['admin_login_error'] = 'This admin account is deactivated.';
            redirect('admin/login');
            return;
        }

        // Regenerate the session id on privilege change to prevent session fixation.
        session_regenerate_id(true);

        $_SESSION['admin_id']       = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_email']    = $user['email'];
        $_SESSION['admin_role']     = $user['role'];

        redirect('products');
    }

    /**
     * GET /admin/logout
     */
    public function logout()
    {
        unset($_SESSION['admin_id'], $_SESSION['admin_username'], $_SESSION['admin_email'], $_SESSION['admin_role']);
        redirect('/');
    }

    /**
     * GET /admin/profile (admin_auth protected)
     */
    public function profile()
    {
        $admin = [
            'id'       => $_SESSION['admin_id'] ?? null,
            'username' => $_SESSION['admin_username'] ?? '',
            'email'    => $_SESSION['admin_email'] ?? '',
            'role'     => $_SESSION['admin_role'] ?? '',
        ];

        $this->call->view('admin_profile', $admin);
    }
}
