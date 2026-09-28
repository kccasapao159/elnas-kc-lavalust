<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
$products = $products ?? [];
$success  = $success ?? null;
$error    = $error ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products · Mindoro State University</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/products.css'); ?>">
</head>
<body>

    <?php include APP_DIR . 'views/_topnav.php'; ?>

    <div class="page-body">
        <div class="panel panel--wide">
            <h1>Product Records</h1>
            <p class="subtitle">Create, update, or remove products. Removed products are archived, never deleted.</p>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="product-toolbar">
                <a href="<?= site_url('products/create'); ?>" class="btn btn-primary">+ Add Product</a>
                <a href="<?= site_url('products/archive'); ?>" class="btn btn-ghost">View Archived Products</a>
            </div>

            <?php if (!empty($products)): ?>
                <div class="product-table-wrap">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $p): ?>
                            <tr>
                                <td>#<?= (int) $p['id']; ?></td>
                                <td><?= htmlspecialchars($p['product_name']); ?></td>
                                <td><?= htmlspecialchars($p['description'] ?? ''); ?></td>
                                <td>&#8369;<?= number_format((float) $p['price'], 2); ?></td>
                                <td><span class="badge-qty"><?= (int) $p['quantity']; ?></span></td>
                                <td><?= htmlspecialchars($p['created_at'] ?? ''); ?></td>
                                <td class="row-actions">
                                    <a href="<?= site_url('products/edit/' . $p['id']); ?>" class="btn btn-secondary">Edit</a>
                                    <form method="POST" action="<?= site_url('products/delete/' . $p['id']); ?>" onsubmit="return confirm('Remove this product? It will be archived, not permanently deleted.');">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">No products yet. Click &ldquo;Add Product&rdquo; to create one.</div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
