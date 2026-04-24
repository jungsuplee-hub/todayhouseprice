<!-- edit_comment_form.php -->
<h2>Edit Comment</h2>
<form action="edit_comment.php" method="POST">
    <input type="text" name="content" placeholder="Edit Comment" required><br><br>
    <input type="hidden" name="comment_id" value="1"> <!-- Replace with the actual comment ID -->
    <button type="submit">Edit Comment</button>
</form>
