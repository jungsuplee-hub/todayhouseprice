<?php
// delete_post.php
include 'db.php';

// Make sure to start the session or authenticate the user before allowing them to delete a post.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id']; // Assuming you stored the user ID in the session after login.

    $stmt = $connection->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Post deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<?php
// logout.php
// Make sure to start the session before calling session_destroy().

session_destroy();
echo "Logged out successfully.";
?>