<?php if ( $post->tags ) : ?>
	<p class="tags">
		<?php foreach ( $post->tag_links as $tag => $tag_link ) : ?>
			<a href="<?= $tag_link ?>" class="btn btn-warning btn-xs"><small><?= $tag ?></small></a>
		<?php endforeach ?>
	</p>
<?php endif ?>