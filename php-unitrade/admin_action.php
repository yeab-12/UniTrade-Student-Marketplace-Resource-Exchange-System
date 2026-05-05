<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if ($id && $action) {
    $status = ($action == 'approve') ? 'approved' : 'rejected';
    $stmt = $pdo->prepare("UPDATE items SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
}

header("Location: dashboard.php");
exit();
