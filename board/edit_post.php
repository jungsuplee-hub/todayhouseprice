<?php
// edit_post.php
include 'db.php';

// Make sure to start the session or authenticate the user before allowing them to edit a post.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id']; // Assuming you stored the user ID in the session after login.

    $stmt = $connection->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssii", $title, $content, $post_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Post updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>