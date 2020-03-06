<?php

	$id = segment(2);

	// add new post form
	if ( $id === 'new' ) {
		include_once 'add-post.php';
		die();
	}

	try {
		$post = get_post( $id );
	}
	catch ( PDOException $e ) {
		$post = false;
	}

	if ( ! $post ) {
		flash()->error("doesn't exist:(");
		redirect('/');
	}

	$page_title = $post->title;
	include_once "_partials/header.php";

?>

	<div class="post-image">
		<?php
			if( isset( $post->image ) ) :
				$image = explode('-', $post->image ) ?>
		
			<?php if( is_file( UPLOAD_DIR . 'source/' . $image[1] ) ) : ?>
				<img src="<?= BASE_URL . '/upload/source/' . $image[1] ?>" alt="" style="max-width:100%">
			<?php endif ?>
		<?php endif ?>
	</div>
	<section class="box">
		<article class="post full-post">

			<header class="post-header">
				<h1 class="box-heading">
					<a href="<?= $post->link ?>"><?= $post->title ?></a>

					<?php if ( can($post, 'post', 'edit') ) : ?>
						<a href="<?= get_edit_link( $post, 'post' ) ?>" class="btn btn-xs edit-link">edit</a>
					<?php endif ?>
					<?php if( can($post, 'post', 'delete') ) : ?>
						<a href="<?= get_delete_link( $post, 'post' ) ?>" class="btn btn-xs edit-link">&times;</a>
					<?php endif ?>

					<time datetime="<?= $post->date ?>">
						<small><?= $post->time ?></small>
					</time>
				</h1>
			</header>

			<div class="post-content">
				<?= $post->text ?>
				<p class="written-by small">
					<small>- written by <a href="<?= $post->user_link ?>"><?= $post->username ?></a></small>
				</p>
			</div>

			<footer class="post-footer">
				<?php include '_partials/tags.php' ?>
			</footer>

		</article>
	</section>

	<section class="box">
		<div class="comments">
			<h2 class="comment-section-title">Leave a comment</h2>

			<?php 
				if( logged_in() ) :
					include '_partials/add-comment-form.php';
				else :
			?> If you want to leave a comment, first <a href="<?= BASE_URL ?>/login">log in</a>.
			<?php endif ?>

			<?php include '_partials/comments.php' ?>
		</div>
	</section>

<?php include_once "_partials/footer.php" ?>