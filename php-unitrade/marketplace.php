<?php
include 'db.php';
$category = $_GET['category'] ?? '';
$q = $_GET['q'] ?? '';

$sql = "SELECT items.*, categories.label as cat_name FROM items 
        JOIN categories ON items.category_id = categories.id 
        WHERE items.status = 'approved'";

if ($category) {
    $sql .= " AND categories.key = " . $pdo->quote($category);
}
if ($q) {
    $sql .= " AND items.title LIKE " . $pdo->quote("%$q%");
}

$items = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Marketplace | UniTrade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary: #1E3A8A; --bg: #F8FAFC; }
        body { background-color: var(--bg); }
        .item-card { border: none; border-radius: 12px; transition: 0.3s; }
        .item-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="fw-bold mb-4">Marketplace</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="card p-4 border-0 shadow-sm rounded-4">
                    <h5 class="fw-bold mb-3">Filters</h5>
                    <form action="marketplace.php" method="GET">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Search</label>
                            <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($q) ?>" placeholder="Search...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Category</label>
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                <?php
                                $cats = $pdo->query("SELECT * FROM categories")->fetchAll();
                                foreach ($cats as $cat) {
                                    $sel = ($category == $cat['key']) ? 'selected' : '';
                                    echo "<option value='{$cat['key']}' $sel>{$cat['label']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Apply</button>
                    </form>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row g-4">
                    <?php if (empty($items)): ?>
                        <div class="text-center py-5">
                            <p class="text-muted">No items found matching your criteria.</p>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($items as $item): ?>
                        <div class="col-md-4">
                            <a href="item.php?id=<?= $item['id'] ?>" class="text-decoration-none text-dark">
                                <div class="card item-card h-100">
                                    <div style="height: 200px; overflow: hidden; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                        <img src="<?= htmlspecialchars($item['image_url'] ?: 'https://via.placeholder.com/300') ?>" class="w-100 h-100 object-fit-cover" alt="...">
                                    </div>
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-1 text-truncate"><?= htmlspecialchars($item['title']) ?></h6>
                                        <p class="small text-muted mb-2"><?= htmlspecialchars($item['cat_name']) ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-primary">ETB <?= number_format($item['price_etb']) ?></span>
                                            <span class="badge bg-light text-dark border"><?= ucfirst($item['condition']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
