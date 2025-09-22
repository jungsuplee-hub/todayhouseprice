<?php
// view_post.php
include 'db.php';

// Retrieve and display the posts along with their comments from the database.
$query = "SELECT p.id, p.title, p.content, u.username 
          FROM posts p 
          JOIN users u ON p.user_id = u.id";
$result = $connection->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Post ID: " . $row["id"] . "<br>";
        echo "Title: " . $row["title"] . "<br>";
        echo "Content: " . $row["content"] . "<br>";
        echo "Author: " . $row["username"] . "<br>";
        echo "<hr>";

        // Fetch and display comments for each post
        $post_id = $row["id"];
        $comment_query = "SELECT c.id, c.content, u.username 
                          FROM comments c 
                          JOIN users u ON c.user_id = u.id 
                          WHERE c.post_id = $post_id";
        $comment_result = $connection->query($comment_query);

        if ($comment_result->num_rows > 0) {
            while ($comment_row = $comment_result->fetch_assoc()) {
                echo "Comment ID: " . $comment_row["id"] . "<br>";
                echo "Content: " . $comment_row["content"] . "<br>";
                echo "Author: " . $comment_row["username"] . "<br>";
                echo "<hr>";
            }
        } else {
            echo "No comments for this post.<br>";
            echo "<hr>";
        }
    }
} else {
    echo "No posts found.";
}

$result->close();
?>