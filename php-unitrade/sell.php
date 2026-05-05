<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header("Location: index.php?error=Only Admin can sell items");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $condition = $_POST['condition'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $seller_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO items (seller_id, category_id, title, description, price_etb, `condition`, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([$seller_id, $category_id, $title, $description, $price, $condition]);
    
    $item_id = $pdo->lastInsertId();

    // Handle Image Uploads
    if (!empty($_FILES['images']['name'][0])) {
        if (!is_dir('uploads')) mkdir('uploads');
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $file_name = time() . '_' . $_FILES['images']['name'][$key];
            move_uploaded_file($tmp_name, "uploads/" . $file_name);
            $image_path = "uploads/" . $file_name;
            $stmt = $pdo->prepare("INSERT INTO item_images (item_id, image_path) VALUES (?, ?)");
            $stmt->execute([$item_id, $image_path]);

            // Set primary image URL
            if ($key == 0) {
                $stmt = $pdo->prepare("UPDATE items SET image_url = ? WHERE id = ?");
                $stmt->execute([$image_path, $item_id]);
            }
        }
    }

    echo "<script>alert('Item submitted for admin approval!'); window.location.href='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sell an item | UniTrade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary: #1E3A8A; --accent: #F59E0B; --bg: #F8FAFC; }
        body { background-color: var(--bg); }
        .form-card { background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-card">
                    <h2 class="fw-bold mb-4">Sell an item</h2>
                    <form action="sell.php" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label font-bold">Title</label>
                                <input type="text" name="title" class="form-control" required placeholder="e.g. Dell Latitude Laptop i5">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select" required>
                                    <?php
                                    $cats = $pdo->query("SELECT * FROM categories")->fetchAll();
                                    foreach ($cats as $cat) echo "<option value='{$cat['id']}'>{$cat['label']}</option>";
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Condition</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="condition" value="new" checked>
                                        <label class="form-check-label">New</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="condition" value="used">
                                        <label class="form-check-label">Used</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Price in ETB</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Images (Up to 5)</label>
                                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">Submit for Approval</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
