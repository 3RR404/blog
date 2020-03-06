<form action="<?= BASE_URL ?>/_admin/add-comment.php" method="post">
    <input type="hidden" name="post_id" value="<?= $post->id ?>">
    <textarea name="text" id="comment" class="form-control" cols="30" rows="10">
        
    </textarea>

    <button type="submit" class="btn btn-warning">Add comment</button>
</form>