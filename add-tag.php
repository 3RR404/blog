<?php


	$page_title = 'Add new post';
	include_once "_partials/header.php";

	if ( isset( $_SESSION['form_data'] ) )
	{
		extract( $_SESSION['form_data'] );
		unset( $_SESSION['form_data'] );
	}

?>

	<section class="box">
		<form action="<?= BASE_URL ?>/_admin/add-tag-item.php" method="post" class="post">
			<header class="post-header">
				<h1 class="box-heading">Add new tag</h1>
			</header>

			<div class="form-group">
				<input type="text" name="tag" class="form-control" value="<?= $title ?: '' ?>" placeholder="title your shit">
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-primary">Add tag</button>
				<span class="or">
					or <a href="<?= BASE_URL ?>">cancel</a>
				</span>
			</div>
		</form>
	</section>


<?php include_once "_partials/footer.php" ?>