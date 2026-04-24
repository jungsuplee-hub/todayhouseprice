<?php
// create_comment.php
include 'db.php';

// Make sure to start the session or authenticate the user before allowing them to create a comment.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id']; // Assuming you stored the user ID in the session after login.

    $stmt = $connection->prepare("INSERT INTO comments (content, post_id, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $content, $post_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Comment created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>