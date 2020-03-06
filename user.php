<?php

	$user = $auth->getUser( segment(2) );

	try {
		$results = get_posts_by_user( $user['uid'] );
	}
	catch ( PDOException $e ) {
		$results = [];
	}

	include_once "_partials/header.php";

?>

	<section class="box post-list">
		<h1 class="box-heading text-muted"><small>by</small> <?= plain( $user['email'] ) ?></h1>
		<?php if ( count($results) ) : foreach ( $results as $post ) : ?>

			<article id="post-<?= $post->id ?>" class="post">
				<header class="post-header">
					<h2>
						<a href="<?= $post->link ?>"><?= $post->title ?></a>
						<time datetime="<?= $post->date ?>">
							<small> /&nbsp;<?= $post->time ?></small>
						</time>
					</h2>
					<?php include '_partials/tags.php' ?>
				</header>
				<div class="post-content">
					<p>
						<?= $post->teaser ?>
					</p>
				</div>
				<div class="footer post-footer">
					<a class="read-more" href="<?= $post->link ?>">
						read more
					</a>
				</div>
			</article>

		<?php endforeach; else : ?>

			<p>we got nothing :(</p>

		<?php endif ?>
	</section>


<?php include_once "_partials/footer.php" ?>