<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'] ?? null;

if ($id) {
    // Delete images references first
    $stmt = $pdo->prepare("DELETE FROM item_images WHERE item_id = ?");
    $stmt->execute([$id]);

    // Delete item
    $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: dashboard.php?msg=Item deleted successfully");
} else {
    header("Location: dashboard.php");
}
exit();
