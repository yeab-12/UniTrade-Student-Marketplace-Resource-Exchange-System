<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$is_admin = ($_SESSION['user_id'] == 1); // Specific admin check as requested

// Fetch stats for the dashboard
if ($is_admin) {
    $stats = [
        'total' => $pdo->query("SELECT COUNT(*) FROM items")->fetchColumn(),
        'approved' => $pdo->query("SELECT COUNT(*) FROM items WHERE status = 'approved'")->fetchColumn(),
        'pending' => $pdo->query("SELECT COUNT(*) FROM items WHERE status = 'pending'")->fetchColumn(),
        'rejected' => $pdo->query("SELECT COUNT(*) FROM items WHERE status = 'rejected'")->fetchColumn(),
    ];
    $items_query = "SELECT items.*, categories.label as cat_name, users.name as seller_name FROM items 
                    JOIN categories ON items.category_id = categories.id 
                    JOIN users ON items.seller_id = users.id
                    ORDER BY items.created_at DESC";
    $stmt = $pdo->prepare($items_query);
    $stmt->execute();
} else {
    $stats = [
        'total' => $pdo->query("SELECT COUNT(*) FROM items WHERE seller_id = $user_id")->fetchColumn(),
        'approved' => $pdo->query("SELECT COUNT(*) FROM items WHERE seller_id = $user_id AND status = 'approved'")->fetchColumn(),
        'pending' => $pdo->query("SELECT COUNT(*) FROM items WHERE seller_id = $user_id AND status = 'pending'")->fetchColumn(),
        'rejected' => $pdo->query("SELECT COUNT(*) FROM items WHERE seller_id = $user_id AND status = 'rejected'")->fetchColumn(),
    ];
    $items_query = "SELECT items.*, categories.label as cat_name FROM items 
                    JOIN categories ON items.category_id = categories.id 
                    WHERE seller_id = ? ORDER BY items.created_at DESC";
    $stmt = $pdo->prepare($items_query);
    $stmt->execute([$user_id]);
}
$items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $is_admin ? 'Admin Panel' : 'My Dashboard' ?> | UniTrade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --primary: #1E3A8A; --bg: #F8FAFC; }
        body { background-color: var(--bg); font-family: 'Segoe UI', sans-serif; }
        .dashboard-nav { background: white; border-bottom: 2px solid #eee; }
        .stat-card { border: none; border-radius: 12px; transition: 0.2s; }
        .stat-card:hover { transform: translateY(-3px); }
    </style>
</head>
<body>
    <nav class="dashboard-nav py-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <a href="index.php" class="h4 fw-bold text-primary text-decoration-none mb-0">UniTrade</a>
                <span class="text-muted d-none d-md-inline">|</span>
                <span class="fw-bold small text-muted d-none d-md-inline"><?= $is_admin ? 'ADMIN DASHBOARD' : 'STUDENT DASHBOARD' ?></span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted d-none d-sm-inline">Hello, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i> <?= htmlspecialchars($_GET['msg']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <div class="mb-5">
            <h1 class="fw-bold h3 mb-2"><?= $is_admin ? 'Manage Listings' : 'My Listings' ?></h1>
            <p class="text-muted"><?= $is_admin ? 'Review and update items across the platform.' : 'Track your sales and manage your listed products.' ?></p>
        </div>

        <!-- Stats Section -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card stat-card shadow-sm p-4 text-center">
                    <p class="text-muted small fw-bold mb-1">Total Items</p>
                    <h2 class="fw-bold mb-0"><?= $stats['total'] ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card shadow-sm p-4 text-center border-start border-4 border-success">
                    <p class="text-muted small fw-bold mb-1">Approved</p>
                    <h2 class="fw-bold text-success mb-0"><?= $stats['approved'] ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card shadow-sm p-4 text-center border-start border-4 border-warning">
                    <p class="text-muted small fw-bold mb-1">Pending</p>
                    <h2 class="fw-bold text-warning mb-0"><?= $stats['pending'] ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card shadow-sm p-4 text-center border-start border-4 border-danger">
                    <p class="text-muted small fw-bold mb-1">Rejected</p>
                    <h2 class="fw-bold text-danger mb-0"><?= $stats['rejected'] ?></h2>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Item History</h4>
            <?php if ($is_admin): ?>
                <a href="sell.php" class="btn btn-primary px-4">+ List New Item</a>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-4 shadow-sm overflow-hidden border">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Item</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Posted</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="fs-1 text-muted mb-3"><i class="bi bi-box"></i></div>
                                        <p class="text-muted mb-3">No items yet</p>
                                        <?php if(!$is_admin): ?>
                                            <a href="sell.php" class="btn btn-primary">Start Selling</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="<?= htmlspecialchars($item['image_url'] ?: 'https://via.placeholder.com/300') ?>" class="rounded-3" style="width: 48px; height: 48px; object-fit: cover;">
                                            <div>
                                                <div class="fw-bold text-dark"><?= htmlspecialchars($item['title']) ?></div>
                                                <?php if($is_admin): ?>
                                                    <div class="small text-muted">Seller: <?= htmlspecialchars($item['seller_name']) ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="small"><?= htmlspecialchars($item['cat_name']) ?></span></td>
                                    <td><span class="fw-bold text-primary">ETB <?= number_format($item['price_etb']) ?></span></td>
                                    <td>
                                        <span class="badge <?= $item['status'] == 'approved' ? 'bg-success' : ($item['status'] == 'pending' ? 'bg-warning' : 'bg-danger') ?>">
                                            <?= ucfirst($item['status']) ?>
                                        </span>
                                    </td>
                                    <td class="small text-muted"><?= date('M d, Y', strtotime($item['created_at'])) ?></td>
                                    <td class="text-end pe-4">
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm rounded-circle shadow-sm" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                <li><a class="dropdown-item" href="item.php?id=<?= $item['id'] ?>"><i class="bi bi-eye me-2"></i> View</a></li>
                                                <?php if ($is_admin): ?>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-primary" href="admin_update.php?id=<?= $item['id'] ?>"><i class="bi bi-pencil me-2"></i> Update Item</a></li>
                                                    <li><a class="dropdown-item text-danger" href="admin_delete.php?id=<?= $item['id'] ?>" onclick="return confirm('Are you sure you want to delete this item?')"><i class="bi bi-trash me-2"></i> Delete Item</a></li>
                                                    <?php if ($item['status'] == 'pending'): ?>
                                                        <li><a class="dropdown-item text-success" href="admin_action.php?id=<?= $item['id'] ?>&action=approve"><i class="bi bi-check-circle me-2"></i> Approve</a></li>
                                                        <li><a class="dropdown-item text-danger" href="admin_action.php?id=<?= $item['id'] ?>&action=reject"><i class="bi bi-x-circle me-2"></i> Reject</a></li>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
