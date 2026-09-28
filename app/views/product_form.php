<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
$product = $product ?? null;
$error   = $error ?? null;
$is_edit = !empty($product);
$action_url = $is_edit ? site_url('products/edit/' . $product['id']) : site_url('products/create');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $is_edit ? 'Edit Product' : 'Add Product'; ?> · Mindoro State University</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/products.css'); ?>">
</head>
<body>

    <?php include APP_DIR . 'views/_topnav.php'; ?>

    <div class="page-body">
        <div class="panel panel--narrow">
            <h1><?= $is_edit ? 'Edit Product' : 'Add Product'; ?></h1>
            <p class="subtitle"><?= $is_edit ? 'Update the details below.' : 'Fill in the details of the new product.'; ?></p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="<?= $action_url; ?>">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" id="product_name" name="product_name" maxlength="100" required
                           value="<?= htmlspecialchars($product['product_name'] ?? ''); ?>" autofocus>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"><?= htmlspecialchars($product['description'] ?? ''); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price (&#8369;)</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required
                               value="<?= htmlspecialchars((string) ($product['price'] ?? '')); ?>">
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="quantity" name="quantity" step="1" min="0" required
                               value="<?= htmlspecialchars((string) ($product['quantity'] ?? '')); ?>">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><?= $is_edit ? 'Save Changes' : 'Add Product'; ?></button>
                    <a href="<?= site_url('products'); ?>" class="btn btn-ghost">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
