<?php
session_start();
require_once 'config.php'; // Database connection using PDO

// Set JSON response header
header('Content-Type: application/json');

// -------------------------
// Validate GET parameter
// -------------------------
$articleId = $_GET['id'] ?? null;

if (!$articleId || !is_numeric($articleId)) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid article ID']);
    exit;
}

try {
    // -------------------------
    // Fetch article from database
    // -------------------------
    $stmt = $pdo->prepare("SELECT title, content FROM articles WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $articleId]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($article) {
        // Encode and return article as JSON
        echo json_encode([
            'title' => $article['title'],
            'content' => $article['content']
        ]);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'Article not found']);
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
