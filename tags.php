<?php include_once "_partials/header.php"; ?>

<section class="box">
	<article class="post full-post">

        <table>
            <thead>
                <th width="200">Tag name</th>
                <th>Action</th>
            </thead>
            <tbody>
            <?php foreach( get_all_tags() as $tag ) : ?>
                <tr>
                    <td>
                        <?= $tag->tag ?>
                    </td>
                    <td>
                        <div class="btn-group">
                        <?php if ( can($tag, 'tag', 'edit') ) : ?>
                            <a href="<?= get_edit_link( $tag, 'tag' ) ?>" class="btn btn-xs btn-warning" title="edit tag <?= $tag->tag ?>">Edit</a>
                        <?php endif ?>
                        <?php if ( can($tag, 'tag', 'delete') ) : ?>
                            <a href="<?= get_delete_link( $tag, 'tag' ) ?>" class="btn btn-xs btn-default" title="delete tag">&times;</a>
                        <?php endif ?>
                        </div>
                    </td>
                </tr>

            <?php endforeach; ?>
            </tbody>
        </table>

    </article>
</section>
<?php include_once "_partials/footer.php" ?>