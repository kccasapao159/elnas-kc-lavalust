<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: ProductController
 *
 * Lab 5 — CRUD Application with Authentication Using LavaLust.
 * Every action here sits behind the `admin_auth` middleware (see
 * app/config/routes.php), so only a logged-in admin can reach it.
 */
class ProductController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->call->model('ProductModel');
        $this->call->model('DeletedProductModel');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * GET /products — Read: display all products.
     */
    public function index()
    {
        $data['products'] = $this->ProductModel->all_products();
        $data['success']  = $_SESSION['product_success'] ?? null;
        $data['error']    = $_SESSION['product_error'] ?? null;
        unset($_SESSION['product_success'], $_SESSION['product_error']);

        $this->call->view('product_index', $data);
    }

    /**
     * GET /products/create
     */
    public function create()
    {
        $data['product'] = null;
        $data['error']   = $_SESSION['product_form_error'] ?? null;
        unset($_SESSION['product_form_error']);

        $this->call->view('product_form', $data);
    }

    /**
     * POST /products/create — Create: add a product.
     */
    public function store()
    {
        [$valid, $errors, $clean] = $this->validate_input($_POST);

        if (!$valid) {
            $_SESSION['product_form_error'] = implode(' ', $errors);
            redirect('products/create');
            return;
        }

        $this->ProductModel->insert($clean);

        $_SESSION['product_success'] = 'Product added successfully.';
        redirect('products');
    }

    /**
     * GET /products/edit/{id}
     */
    public function edit($id)
    {
        $product = $this->ProductModel->find((int) $id);

        if (empty($product)) {
            $_SESSION['product_error'] = 'Product not found.';
            redirect('products');
            return;
        }

        $data['product'] = $product;
        $data['error']   = $_SESSION['product_form_error'] ?? null;
        unset($_SESSION['product_form_error']);

        $this->call->view('product_form', $data);
    }

    /**
     * POST /products/edit/{id} — Update: edit a product.
     */
    public function update($id)
    {
        $id = (int) $id;
        $product = $this->ProductModel->find($id);

        if (empty($product)) {
            $_SESSION['product_error'] = 'Product not found.';
            redirect('products');
            return;
        }

        [$valid, $errors, $clean] = $this->validate_input($_POST);

        if (!$valid) {
            $_SESSION['product_form_error'] = implode(' ', $errors);
            redirect('products/edit/' . $id);
            return;
        }

        $this->ProductModel->update($id, $clean);

        $_SESSION['product_success'] = 'Product updated successfully.';
        redirect('products');
    }

    /**
     * POST /products/delete/{id} — Delete: archive-then-remove.
     *
     * The product row is NEVER simply DELETEd out of existence. It is
     * copied into `deleted_products` (DeletedProductModel) first, and
     * only removed from the live `products` table once that copy is
     * safely stored — a soft delete that lives in a different table.
     */
    public function delete($id)
    {
        $id = (int) $id;
        $product = $this->ProductModel->find($id);

        if (empty($product)) {
            $_SESSION['product_error'] = 'Product not found.';
            redirect('products');
            return;
        }

        $this->DeletedProductModel->insert([
            'original_product_id' => $product['id'],
            'product_name'        => $product['product_name'],
            'description'         => $product['description'],
            'price'               => $product['price'],
            'quantity'            => $product['quantity'],
            'original_created_at' => $product['created_at'],
            'deleted_by'          => $_SESSION['admin_username'] ?? 'admin',
            'deleted_at'          => date('Y-m-d H:i:s'),
        ]);

        $this->ProductModel->delete($id);

        $_SESSION['product_success'] = 'Product removed and archived (not permanently deleted).';
        redirect('products');
    }

    /**
     * GET /products/archive — view soft-deleted / archived products.
     */
    public function archive()
    {
        $data['deleted'] = $this->DeletedProductModel->all_deleted();
        $this->call->view('product_archive', $data);
    }

    /**
     * Shared validation for create/update.
     *
     * @return array [bool $valid, array $errors, array $clean]
     */
    private function validate_input(array $input)
    {
        $errors = [];

        $product_name = trim($input['product_name'] ?? '');
        $description  = trim($input['description'] ?? '');
        $price        = $input['price'] ?? '';
        $quantity     = $input['quantity'] ?? '';

        if ($product_name === '' || mb_strlen($product_name) > 100) {
            $errors[] = 'Product name is required (max 100 characters).';
        }

        if (!is_numeric($price) || (float) $price < 0) {
            $errors[] = 'Price must be a valid non-negative number.';
        }

        if (!ctype_digit((string) $quantity)) {
            $errors[] = 'Quantity must be a valid non-negative whole number.';
        }

        $clean = [
            'product_name' => $product_name,
            'description'  => $description,
            'price'        => (float) $price,
            'quantity'     => (int) $quantity,
        ];

        return [empty($errors), $errors, $clean];
    }
}
