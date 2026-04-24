<!-- create_comment_form.php -->
<h2>Create Comment</h2>
<form action="create_comment.php" method="POST">
    <input type="text" name="content" placeholder="Comment" required><br><br>
    <input type="hidden" name="post_id" value="1"> <!-- Replace with the actual post ID -->
    <button type="submit">Add Comment</button>
</form>

