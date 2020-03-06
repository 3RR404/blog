<?php

	try {
		$tag = get_tag( segment(3), false );
	}
	catch ( PDOException $e ) {
		$tag = false;
	}


	if ( ! $tag ) {
		flash()->error("doesn't exist:(");
		redirect('/');
	}

	$page_title = 'EDIT / ' . $tag->tag;
	include_once "_partials/header.php";

?>

	<section class="box">
		<form action="<?= BASE_URL ?>/_admin/edit-tag-item.php" method="post" class="post">
			<header class="post-header">
				<h1 class="box-heading">Edit &ldquo;<?= plain( $tag->tag ) ?>&rdquo;</h1>
			</header>

			<div class="form-group">
				<input type="text" name="tag" class="form-control" value="<?= $tag->tag ?: '' ?>" placeholder="title your shit">
			</div>

			<div class="form-group">
				<input name="tag_id" value="<?= $tag->id ?>" type="hidden">
				<button type="submit" class="btn btn-primary">Update tag</button>
				<span class="or">
					or <a href="<?= BASE_URL ?>/tags">cancel</a>
				</span>
			</div>
		</form>
	</section>

<?php include_once "_partials/footer.php" ?>