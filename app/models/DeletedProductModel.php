<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Model: DeletedProductModel
 *
 * Holds every product that was ever "deleted" from the Lab 5 app.
 * ProductController::delete() writes a copy here BEFORE removing the
 * live row from `products`, so a delete never destroys data — it just
 * moves it to this archive table.
 */
class DeletedProductModel extends Model {
    protected $table = 'deleted_products';
    protected $primary_key = 'id';
    protected $fillable = [
        'original_product_id',
        'product_name',
        'description',
        'price',
        'quantity',
        'original_created_at',
        'deleted_by',
        'deleted_at',
    ];
    protected $guarded = ['id'];
    protected $timestamps = false;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * All archived products, most recently deleted first.
     */
    public function all_deleted()
    {
        return $this->db->table($this->table)
                        ->order_by('deleted_at', 'DESC')
                        ->get_all();
    }
}
