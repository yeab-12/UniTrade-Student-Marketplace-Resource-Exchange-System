<?php
include 'db.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT items.*, categories.label as cat_name, profiles.full_name as seller_name, profiles.telegram_username 
                       FROM items 
                       JOIN categories ON items.category_id = categories.id 
                       JOIN profiles ON items.seller_id = profiles.user_id
                       WHERE items.id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) die("Item not found");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($item['title']) ?> | UniTrade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <a href="marketplace.php" class="btn btn-outline-dark mb-4">Back to Marketplace</a>
        <div class="row g-5">
            <div class="col-md-6">
                <img src="<?= htmlspecialchars($item['image_url'] ?: 'https://via.placeholder.com/600') ?>" class="img-fluid rounded-4 shadow w-100" alt="...">
            </div>
            <div class="col-md-6">
                <span class="badge bg-primary mb-2"><?= htmlspecialchars($item['cat_name']) ?></span>
                <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($item['title']) ?></h1>
                <h2 class="text-primary fw-bold mb-4">ETB <?= number_format($item['price_etb']) ?></h2>
                <div class="mb-4">
                    <span class="badge bg-light text-dark border p-2">Condition: <?= ucfirst($item['condition']) ?></span>
                </div>
                <div class="card p-4 border-0 shadow-sm mb-4">
                    <h5 class="fw-bold mb-3">Description</h5>
                    <p class="text-muted"><?= nl2br(htmlspecialchars($item['description'])) ?></p>
                </div>
                <div class="card p-4 border-0 shadow-sm">
                    <h5 class="fw-bold mb-3">Seller Information</h5>
                    <div class="d-flex items-center mb-3">
                        <div class="bg-primary text-white rounded-circle p-2 me-3">
                            <i class="bi bi-person"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold"><?= htmlspecialchars($item['seller_name']) ?></h6>
                            <small class="text-muted">Verified ASTU Student</small>
                        </div>
                    </div>
                    <a href="https://t.me/<?= ltrim($item['telegram_username'], '@') ?>" class="btn btn-primary btn-lg w-100">
                        Contact on Telegram
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
