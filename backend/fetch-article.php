<?php
session_start();
require_once 'config.php'; // DB connection using PDO

header('Content-Type: application/json');

// Validate GET parameter
$articleId = $_GET['id'] ?? null;

if (!$articleId || !is_numeric($articleId)) {
    echo json_encode(['error' => 'Invalid article ID']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT title, content FROM articles WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $articleId]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($article) {
        echo json_encode($article);
    } else {
        echo json_encode(['error' => 'Article not found']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
