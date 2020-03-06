<?php
	
	try {
		$post = get_post( segment(3) );
	}
	catch ( PDOException $e ) {
		$post = false;
	}

	if ( ! $post ) {
		flash()->error("doesn't exist:(");
		redirect('/');
	}

	if ( !can( $post, 'post', 'delete' ) ) {
		redirect('/');
	}

	$page_title = 'DELETE / ' . $post->title;
	include_once "_partials/header.php";

?>

	<section class="box">
		<form action="<?= BASE_URL ?>/_admin/delete-item.php" method="post" class="post">
			<header class="post-header">
				<h1 class="box-heading">
					Sure you wanna do this?
				</h1>
			</header>

			<blockquote class="form-group">
				<h3>&ldquo;<?= $post->title ?>&rdquo;</h3>
				<p class="teaser"><?= $post->teaser ?></p>
			</blockquote>

			<div class="form-group">
				<input name="post_id" value="<?= $post->id ?>" type="hidden">
				<button type="submit" class="btn btn-primary">Delete post</button>
				<span class="or">
					or <a href="<?= get_post_link( $post ) ?>">cancel</a>
				</span>
			</div>
		</form>
	</section>

<?php include_once "_partials/footer.php" ?>