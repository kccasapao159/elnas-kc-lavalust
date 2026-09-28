<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Model: ProductModel
 *
 * Handles the `products` table for the Lab 5 CRUD application.
 * Deletion is intentionally NOT handled here with a hard DELETE call
 * from a controller — see ProductController::delete(), which copies the
 * row into DeletedProductModel (table `deleted_products`) first and only
 * removes it from `products` afterwards, so nothing is ever truly lost.
 */
class ProductModel extends Model {
    protected $table = 'products';
    protected $primary_key = 'id';
    protected $fillable = ['product_name', 'description', 'price', 'quantity'];
    protected $guarded = ['id'];
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * All products, newest first.
     */
    public function all_products()
    {
        return $this->db->table($this->table)
                        ->order_by('id', 'DESC')
                        ->get_all();
    }
}
