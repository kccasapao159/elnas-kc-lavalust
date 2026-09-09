<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
$deleted = $deleted ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Products · Mindoro State University</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/products.css'); ?>">
</head>
<body>

    <?php include APP_DIR . 'views/_topnav.php'; ?>

    <div class="page-body">
        <div class="panel panel--wide">
            <h1>Archived Products</h1>
            <p class="subtitle">Products removed from the live list live here, in the <code>deleted_products</code> table — nothing is ever hard-deleted.</p>

            <div class="product-toolbar">
                <a href="<?= site_url('products'); ?>" class="btn btn-ghost">&larr; Back to Products</a>
            </div>

            <?php if (!empty($deleted)): ?>
                <div class="product-table-wrap">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Original ID</th>
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Deleted By</th>
                                <th>Deleted At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($deleted as $d): ?>
                            <tr>
                                <td>#<?= (int) $d['original_product_id']; ?></td>
                                <td><?= htmlspecialchars($d['product_name']); ?></td>
                                <td><?= htmlspecialchars($d['description'] ?? ''); ?></td>
                                <td>&#8369;<?= number_format((float) $d['price'], 2); ?></td>
                                <td><span class="badge-qty"><?= (int) $d['quantity']; ?></span></td>
                                <td><?= htmlspecialchars($d['deleted_by'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($d['deleted_at'] ?? ''); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">No archived products yet.</div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
