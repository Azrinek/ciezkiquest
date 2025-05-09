<?php
require 'config.php';

function fetchData($url) {
    $data = file_get_contents($url);
    return json_decode($data, true);
}

echo "Pobieranie danych...\n";

// USERS
$users = fetchData('https://jsonplaceholder.typicode.com/users');
foreach ($users as $user) {
    $stmt = $pdo->prepare("REPLACE INTO users (id, name, username, email, phone, website) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $user['id'],
        $user['name'],
        $user['username'],
        $user['email'],
        $user['phone'],
        $user['website']
    ]);
}

// POSTS
$posts = fetchData('https://jsonplaceholder.typicode.com/posts');
foreach ($posts as $post) {
    $stmt = $pdo->prepare("REPLACE INTO posts (id, user_id, title, body) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $post['id'],
        $post['userId'],
        $post['title'],
        $post['body']
    ]);
}

// COMMENTS
$comments = fetchData('https://jsonplaceholder.typicode.com/comments');
foreach ($comments as $comment) {
    $stmt = $pdo->prepare("REPLACE INTO comments (id, post_id, name, email, body) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $comment['id'],
        $comment['postId'],
        $comment['name'],
        $comment['email'],
        $comment['body']
    ]);
}

echo "Zakończono synchronizację.\n";
?>