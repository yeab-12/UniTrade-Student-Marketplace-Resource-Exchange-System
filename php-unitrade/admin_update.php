<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit();
}

// Fetch item details
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];

    // If a manual upload happened
    if (!empty($_FILES['image_file']['name'])) {
        if (!is_dir('uploads')) mkdir('uploads');
        $file_name = time() . '_' . $_FILES['image_file']['name'];
        move_uploaded_file($_FILES['image_file']['tmp_name'], "uploads/" . $file_name);
        $image_url = "uploads/" . $file_name;
    }

    $stmt = $pdo->prepare("UPDATE items SET title = ?, price_etb = ?, image_url = ? WHERE id = ?");
    $stmt->execute([$title, $price, $image_url, $id]);
    header("Location: dashboard.php?msg=Item updated successfully");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Item | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-5 border-0 shadow rounded-4">
                    <h3 class="fw-bold mb-4">Update Item: <?= htmlspecialchars($item['title']) ?></h3>
                    <form action="admin_update.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Item Name (Title)</label>
                            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($item['title']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Price (ETB)</label>
                            <input type="number" name="price" class="form-control" value="<?= $item['price_etb'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Current Image URL</label>
                            <input type="text" name="image_url" class="form-control mb-2" value="<?= htmlspecialchars($item['image_url']) ?>">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Or Upload New Image</label>
                            <input type="file" name="image_file" class="form-control">
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4 flex-grow-1 py-3 fw-bold">Update Listing</button>
                            <a href="dashboard.php" class="btn btn-outline-secondary px-4 py-3 fw-bold">Cancel</a>
                        </div>
                    </form>
                </div>
                <div class="mt-4 text-center">
                    <img src="<?= htmlspecialchars($item['image_url']) ?>" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
