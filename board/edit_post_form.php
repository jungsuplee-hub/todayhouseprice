<!-- edit_post_form.php -->
<h2>Edit Post</h2>
<form action="edit_post.php" method="POST">
    <input type="text" name="title" placeholder="Edit Title" required><br><br>
    <textarea name="content" placeholder="Edit Content" rows="4" cols="50" required></textarea><br><br>
    <input type="hidden" name="post_id" value="1"> <!-- Replace with the actual post ID -->
    <button type="submit">Edit Post</button>
</form>