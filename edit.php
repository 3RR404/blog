<?php

	try {
		$post = get_post( segment(3), false );
	}
	catch ( PDOException $e ) {
		$post = false;
	}

	if ( ! $post ) {
		flash()->error("doesn't exist:(");
		redirect('/');
	}

	$page_title = 'EDIT / ' . $post->title;
	include_once "_partials/header.php";

?>

	<section class="box">
		<form action="<?= BASE_URL ?>/_admin/edit-item.php" method="post" class="post" enctype='multipart/form-data'>
			<header class="post-header">
				<h1 class="box-heading">
					Edit &ldquo;<?= plain( $post->title ) ?>&rdquo;
				</h1>
			</header>

			<div class="form-group mb-3">
				<input type="text" name="title" class="form-control" value="<?= $post->title ?>" placeholder="title your shit">
			</div>

			<div class="form-group mb-3">
				<textarea class="form-control" name="text" rows="16" placeholder="write your shit"><?= $post->text ?></textarea>
			</div>

			<div class="form-group mb-3">
				<label class="tags">Tagy</label>
				<select name="tags[]" id="tags" class="form-control" multiple>
						<?php foreach ( get_all_tags( $post->id ) as $tag ) : ?>
						<option value="<?= $tag->id ?>"<?= isset($tag->checked) && $tag->checked ? ' selected="selected"' : '' ?>><?= plain( $tag->tag ) ?></option>
					<?php endforeach ?>
				</select>
			</div>

			<div class="form-group mb-3">
				<label for="image">Title image</label>
				<?php if( is_file( UPLOAD_DIR . '/thumb/150_x_' . $post->image ) ) : ?>
					<img src="<?= BASE_URL . '/upload/thumb/150_x_' . $post->image ?>" alt="">
				<?php endif; ?>
				<input type="file" name="image" class="form-group" id="image" value="<?= $post->image ?>" />
			</div>

			<div class="form-group">
				<input name="post_id" value="<?= $post->id ?>" type="hidden">
				<button type="submit" class="btn btn-primary">Edit post</button>
				<span class="or">
					or <a href="<?= get_post_link( $post ) ?>">cancel</a>
				</span>
			</div>
		</form>
	</section>

<?php include_once "_partials/footer.php" ?>