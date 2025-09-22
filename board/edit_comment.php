<?php
// edit_comment.php
include 'db.php';

// Make sure to start the session or authenticate the user before allowing them to edit a comment.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];
    $comment_id = $_POST['comment_id'];
    $user_id = $_SESSION['user_id']; // Assuming you stored the user ID in the session after login.

    $stmt = $connection->prepare("UPDATE comments SET content = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sii", $content, $comment_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Comment updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>