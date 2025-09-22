<?php
// create_post.php
include 'db.php';

// Make sure to start the session or authenticate the user before allowing them to create a post.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id']; // Assuming you stored the user ID in the session after login.

    $stmt = $connection->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $content, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Post created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>