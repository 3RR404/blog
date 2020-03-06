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
		<form action="<?= BASE_URL ?>/_admin/add-item.php" method="post" class="post">
			<header class="post-header">
				<h1 class="box-heading">Add new post</h1>
			</header>

			<div class="form-group mb-3">
				<input type="text" name="title" class="form-control" value="<?= $title ?: '' ?>" placeholder="title your shit">
			</div>

			<div class="form-group mb-3">
				<textarea class="form-control" name="text" rows="16" placeholder="write your shit"><?= $text ?: '' ?></textarea>
			</div>

			<div class="form-group mb-3">
				<label class="tags">Tagy</label>
				<select name="tags[]" id="tags" class="form-control" multiple>
						<?php foreach ( get_all_tags() as $tag ) : ?>
								<option value="<?= $tag->id ?>"<?= $tag->checked || in_array( $tag->id, $tags ?: [] ) ? 'selected' : '' ?>>
							<?= plain( $tag->tag ) ?></option>
					<?php endforeach ?>
				</select>
			</div>

			<div class="form-group mb-3">
				<label for="image">Title image</label>
				<input type="file" name="image" class="form-group" id="image" />
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-primary">Add post</button>
				<span class="or">
					or <a href="<?= BASE_URL ?>">cancel</a>
				</span>
			</div>
		</form>
	</section>


<?php include_once "_partials/footer.php" ?>