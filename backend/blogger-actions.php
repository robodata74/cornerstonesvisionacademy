<?php
session_start();
require_once 'config.php'; // DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if (!$userId || !$action) {
        $_SESSION['error'] = "Invalid request.";
        header("Location: ../dashboard-dark.html");
        exit;
    }

    try {
        if ($action === 'approve') {
            $stmt = $pdo->prepare("UPDATE bloggers SET status = 'Approved' WHERE id = :id");
            $stmt->execute(['id' => $userId]);
            $_SESSION['success'] = "Blogger approved successfully.";
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM bloggers WHERE id = :id");
            $stmt->execute(['id' => $userId]);
            $_SESSION['success'] = "Blogger deleted successfully.";
        } else {
            $_SESSION['error'] = "Unknown action.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }

    header("Location: ../dashboard-dark.html");
    exit;
}
?>
