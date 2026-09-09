<?php

/**
 * Archive table for "soft-deleted" products.
 *
 * Lab 5 requires that deleting a product must NOT permanently remove it
 * from the database. Instead of flagging a `deleted_at` column on the
 * same `products` row, this app moves the row into a separate
 * `deleted_products` table and only then removes it from `products`.
 * That way the live table always reflects only active products, while
 * nothing is ever actually lost.
 */
class Create_deleted_products_table {

    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->dbforge();
    }

    public function up()
    {
        if ($this->_lava->dbforge->table_exists('deleted_products')) {
            return;
        }

        $this->_lava->dbforge
            ->add_field([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => TRUE,
                    'auto_increment' => TRUE,
                    'null'           => FALSE,
                ],
                'original_product_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => TRUE,
                    'null'       => FALSE,
                ],
                'product_name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => FALSE,
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => TRUE,
                ],
                'price' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '10,2',
                    'null'       => FALSE,
                    'default'    => 0,
                ],
                'quantity' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => TRUE,
                    'null'       => FALSE,
                    'default'    => 0,
                ],
                'original_created_at' => [
                    'type' => 'DATETIME',
                    'null' => TRUE,
                ],
                'deleted_by' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => TRUE,
                ],
                'deleted_at' => [
                    'type'    => 'DATETIME',
                    'null'    => FALSE,
                    'default' => 'CURRENT_TIMESTAMP',
                ],
            ])
            ->add_key('id', primary: TRUE)
            ->add_key('original_product_id', name: 'original_product_id_idx')
            ->create_table('deleted_products');
    }

    public function down()
    {
        $this->_lava->dbforge->drop_table('deleted_products');
    }
}
