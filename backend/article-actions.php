<?php
session_start();
require_once 'config.php'; // DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $articleId = $_POST['article_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if (!$articleId || !$action) {
        $_SESSION['error'] = "Invalid request.";
        header("Location: ../dashboard-dark.html");
        exit;
    }

    try {
        if ($action === 'approve') {
            $stmt = $pdo->prepare("UPDATE articles SET status = 'Approved' WHERE id = :id");
            $stmt->execute(['id' => $articleId]);
            $_SESSION['success'] = "Article approved successfully.";
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM articles WHERE id = :id");
            $stmt->execute(['id' => $articleId]);
            $_SESSION['success'] = "Article deleted successfully.";
        } elseif ($action === 'feature') {
            $stmt = $pdo->prepare("UPDATE articles SET featured = 1 WHERE id = :id");
            $stmt->execute(['id' => $articleId]);
            $_SESSION['success'] = "Article marked as featured.";
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
