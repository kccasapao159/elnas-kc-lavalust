<?php

/**
 * Seeds one default admin account (role = 'admin') so the Lab 5
 * authentication flow can be demonstrated immediately after migrating.
 *
 * Default login:
 *   username: admin
 *   password: Admin@12345
 *
 * Change this password (or delete/replace this row) before submitting
 * or deploying — never leave a seeded default credential in production.
 */
class Seed_admin_user {

    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->dbforge();
        $this->_lava->call->database();
    }

    public function up()
    {
        if (!$this->_lava->dbforge->table_exists('users')) {
            return;
        }

        $existing = $this->_lava->db->table('users')->where('username', 'admin')->get();

        if (!empty($existing)) {
            return;
        }

        // Base columns every version of the `users` table has.
        $data = [
            'username' => 'admin',
            'email'    => 'admin@minsu.edu.ph',
            'password' => password_hash('Admin@12345', PASSWORD_DEFAULT),
            'role'     => 'admin',
            'is_active' => 1,
        ];

        // Your live table also has firstname/lastname (not part of the
        // original 001 migration's schema) — fill them only if present,
        // so this seed works whichever schema variant is actually there.
        if ($this->_lava->dbforge->column_exists('users', 'firstname')) {
            $data['firstname'] = 'Admin';
        }
        if ($this->_lava->dbforge->column_exists('users', 'lastname')) {
            $data['lastname'] = 'Account';
        }
        if ($this->_lava->dbforge->column_exists('users', 'created_at')) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        $this->_lava->db->table('users')->insert($data);
    }

    public function down()
    {
        $this->_lava->call->database();
        $this->_lava->db->table('users')->where('username', 'admin')->delete();
    }
}
