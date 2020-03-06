<?php

	try {
		$tag = get_tag( segment(3) );
	}
	catch ( PDOException $e ) {
		$tag = false;
	}

	if ( ! $tag ) {
		flash()->error("doesn't exist:(");
		redirect('/');
	}

	$page_title = 'DELETE / ' . $tag->title;
	include_once "_partials/header.php";

?>

	<section class="box">
		<form action="<?= BASE_URL ?>/_admin/delete-tag-item.php" method="post" class="post">
			<header class="post-header">
				<h1 class="box-heading">
					Sure you wanna do this?
				</h1>
			</header>

			<blockquote class="form-group">
				<h3>&ldquo;<?= $tag->tag ?>&rdquo;</h3>
			</blockquote>

			<div class="form-group">
				<input name="tag_id" value="<?= $tag->id ?>" type="hidden">
				<button type="submit" class="btn btn-primary">Delete this tag</button>
				<span class="or">
					or <a href="<?= get_post_link( $tag ) ?>">cancel</a>
				</span>
			</div>
		</form>
	</section>

<?php include_once "_partials/footer.php" ?>