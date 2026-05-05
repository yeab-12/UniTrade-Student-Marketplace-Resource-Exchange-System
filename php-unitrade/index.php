<?php 
include 'db.php'; 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniTrade | Adama Science & Tech Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --primary: #1E3A8A; --accent: #F59E0B; --bg: #F8FAFC; --text: #0F172A; }
        body { background-color: var(--bg); color: var(--text); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background: white; border-bottom: 2px solid #eee; }
        .btn-primary { background-color: var(--primary); border: none; }
        .hero { padding: 80px 0; background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%); }
        .category-card { transition: transform 0.2s; cursor: pointer; border: none; border-radius: 12px; }
        .category-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .item-card { border-radius: 12px; overflow: hidden; border: none; transition: 0.3s; }
        .item-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
        .footer { background: white; border-top: 2px solid #eee; padding: 40px 0; margin-top: 60px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="index.php">UniTrade</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplace</a></li>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1): ?>
                    <li class="nav-item"><a class="nav-link" href="sell.php">Sell</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link fw-bold text-primary" href="dashboard.php">Dashboard</a></li>
                <?php endif; ?>
            </ul>
            <div class="d-flex gap-2">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="btn btn-outline-primary px-4">Dashboard</a>
                    <a href="logout.php" class="btn btn-light text-danger border">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-primary px-4">Login</a>
                    <a href="signup.php" class="btn btn-primary px-4">Join UniTrade</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<?php if (isset($_GET['error'])): ?>
    <div class="container mt-3">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> <?= htmlspecialchars($_GET['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<section class="hero text-center sm:text-start">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="badge bg-primary-subtle text-primary mb-3">Shop safely with students</span>
                <h1 class="display-4 fw-bold mb-4">The marketplace for UniTrade</h1>
                <p class="lead text-muted mb-4">Buy, sell and exchange electronics, books, clothes and dorm essentials with verified students — priced in Ethiopian Birr, delivered through Telegram.</p>
                <div class="input-group mb-4 shadow-sm" style="max-width: 500px;">
                    <input type="text" class="form-control form-control-lg" placeholder="Search laptops, books, jackets...">
                    <button class="btn btn-primary btn-lg" type="button">Search</button>
                </div>
                <div class="d-flex gap-3">
                    <a href="marketplace.php" class="btn btn-primary btn-lg px-4">Browse marketplace</a>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1): ?>
                        <a href="sell.php" class="btn btn-outline-dark btn-lg px-4">Sell an item</a>
                    <?php endif; ?>
                </div>
                <div class="mt-4 text-muted small">
                    <i class="bi bi-check-circle-fill text-success me-1"></i> Verified students only — UGR ID + ASTU email required
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1000&auto=format&fit=crop" alt="Students" class="img-fluid rounded-4 shadow-lg">
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Browse by category</h2>
        <p class="text-muted">Find exactly what you need on campus.</p>
    </div>
    <div class="row g-4">
        <?php
        $cats = $pdo->query("SELECT * FROM categories")->fetchAll();
        foreach ($cats as $cat):
            $cat_info = [
                'electronics' => ['icon' => 'bi-laptop', 'img' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?q=80&w=300'],
                'stationery' => ['icon' => 'bi-book', 'img' => 'https://images.unsplash.com/photo-1456735190827-d1262f71b8a3?q=80&w=300'],
                'clothes' => ['icon' => 'bi-shirt', 'img' => 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?q=80&w=300'],
                'shoes' => ['icon' => 'bi-footprints', 'img' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=300'],
                'food' => ['icon' => 'bi-cup-hot', 'img' => 'https://images.unsplash.com/photo-1512152272829-e3139592d56f?q=80&w=300'],
                'dorm' => ['icon' => 'bi-house', 'img' => 'https://images.unsplash.com/photo-1555854817-40e09886a9e1?q=80&w=300']
            ];
            $info = $cat_info[$cat['key']] ?? ['icon' => 'bi-box', 'img' => 'https://via.placeholder.com/300'];
        ?>
        <div class="col-6 col-md-4 col-lg-2">
            <a href="marketplace.php?category=<?= $cat['key'] ?>" class="text-decoration-none">
                <div class="card category-card h-100 shadow-sm border-0 overflow-hidden">
                    <div style="height: 120px; position: relative;">
                        <img src="<?= $info['img'] ?>" class="w-100 h-100 object-fit-cover" alt="<?= $cat['label'] ?>">
                        <div class="position-absolute top-0 end-0 m-2 bg-white rounded-circle p-1 shadow-sm d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <i class="bi <?= $info['icon'] ?> text-primary small"></i>
                        </div>
                    </div>
                    <div class="p-2 text-center">
                        <h6 class="fw-bold text-dark mb-0 small"><?= $cat['label'] ?></h6>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Featured items</h2>
            <p class="text-muted">Newly approved by our admin team.</p>
        </div>
        <a href="marketplace.php" class="text-primary fw-bold text-decoration-none">See all <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row g-4">
        <?php
        $featured = $pdo->query("SELECT items.*, categories.label as cat_name FROM items 
                               JOIN categories ON items.category_id = categories.id 
                               WHERE items.status = 'approved' 
                               ORDER BY items.created_at DESC LIMIT 4")->fetchAll();
        foreach ($featured as $item):
        ?>
        <div class="col-md-3">
             <a href="item.php?id=<?= $item['id'] ?>" class="text-decoration-none text-dark">
                <div class="card item-card h-100 shadow-sm border-0">
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
</section>

<section class="bg-dark text-white py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">How UniTrade works</h2>
            <p class="text-secondary">Three simple steps from listing to sale.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4 text-center">
                <div class="fs-1 text-accent mb-3"><i class="bi bi-cloud-upload"></i></div>
                <h5 class="fw-bold">Upload your item</h5>
                <p class="text-secondary">Snap a photo, add a price in ETB, write a quick description and submit.</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="fs-1 text-accent mb-3"><i class="bi bi-shield-check"></i></div>
                <h5 class="fw-bold">Admin approval</h5>
                <p class="text-secondary">Our team reviews each listing to keep UniTrade safe and trustworthy.</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="fs-1 text-accent mb-3"><i class="bi bi-send"></i></div>
                <h5 class="fw-bold">Sell via Telegram</h5>
                <p class="text-secondary">Buyers contact you directly on Telegram. Meet on campus, exchange, done.</p>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <h4 class="fw-bold text-primary mb-3">UniTrade</h4>
                <p class="text-muted" style="max-width: 400px;">The trusted student marketplace for Adama Science and Technology University. Buy, sell, and exchange items safely — verified students only.</p>
            </div>
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Explore</h6>
                <ul class="list-unstyled">
                    <li><a href="marketplace.php" class="text-decoration-none text-muted">Marketplace</a></li>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1): ?>
                        <li><a href="sell.php" class="text-decoration-none text-muted">Sell an item</a></li>
                    <?php endif; ?>
                    <li><a href="contact.php" class="text-decoration-none text-muted">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Account</h6>
                <ul class="list-unstyled">
                    <li><a href="signup.php" class="text-decoration-none text-muted">Sign up</a></li>
                    <li><a href="login.php" class="text-decoration-none text-muted">Login</a></li>
                    <li><a href="dashboard.php" class="text-decoration-none text-muted">My dashboard</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-4">
        <div class="text-center text-muted small">
            &copy; 2026 UniTrade &middot; Built for ASTU students
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
