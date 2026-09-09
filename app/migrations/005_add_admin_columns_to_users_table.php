<?php

/**
 * Your live `users` table (id, firstname, lastname, email, username) was
 * created outside of 001_create_users_table's migration — that migration's
 * table_exists() guard makes it a no-op since `users` already exists, so
 * it never actually added `password` / `role` / `is_active`.
 *
 * Admin login (AuthController) needs those three columns to check a
 * password and confirm role = 'admin'. This migration adds them to your
 * EXISTING table — it does not touch or drop firstname/lastname/email/
 * username, and it will not fail or duplicate columns if one of them
 * already exists (each add is guarded by column_exists()).
 */
class Add_admin_columns_to_users_table {

    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->dbforge();
    }

    public function up()
    {
        if (!$this->_lava->dbforge->table_exists('users')) {
            return;
        }

        if (!$this->_lava->dbforge->column_exists('users', 'password')) {
            $this->_lava->dbforge->add_column('users', [
                'password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => TRUE,
                    'after'      => 'username',
                ],
            ]);
        }

        if (!$this->_lava->dbforge->column_exists('users', 'role')) {
            $this->_lava->dbforge->add_column('users', [
                'role' => [
                    'type'       => 'ENUM',
                    'constraint' => "'admin','moderator','user'",
                    'null'       => FALSE,
                    'default'    => 'user',
                    'after'      => 'password',
                ],
            ]);
        }

        if (!$this->_lava->dbforge->column_exists('users', 'is_active')) {
            $this->_lava->dbforge->add_column('users', [
                'is_active' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'unsigned'   => TRUE,
                    'null'       => FALSE,
                    'default'    => 1,
                    'after'      => 'role',
                ],
            ]);
        }
    }

    public function down()
    {
        if (!$this->_lava->dbforge->table_exists('users')) {
            return;
        }

        foreach (['is_active', 'role', 'password'] as $column) {
            if ($this->_lava->dbforge->column_exists('users', $column)) {
                $this->_lava->dbforge->drop_column('users', $column);
            }
        }
    }
}
