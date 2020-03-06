<?php if ( isset( $post->id ) ) : ?>
    <?php if( postHasComments( $post->id ) ) : ?>
        <?php foreach( getComments( $post->id ) as $comment ): 
                $comment = format_comment( $comment, true ); ?>

            <div class="comment">
                <div class="comment-heading">
                    <span class="text-warning">
                        <strong>
                            <?= $comment->username ?>
                        </strong>
                    </span>
                    <span class="text-muted muted small">
                        commented that
                    </span>
                    <div>
                        <span class="text-muted small muted">
                            <strong>at time</strong>
                            <time datetime="<?= $comment->date ?>">
                                <small>
                                    <?= $comment->time ?>
                                </small>
                            </time>
                        </span>
        
                        <?php if( can( $comment, 'comment', 'edit' ) ) : ?>
                            <a href="" class="btn btn-xs edit-link">
                                Edit
                            </a>
                        <?php endif ?>
                        <?php if( can( $comment, 'comment', 'delete' ) ) : ?>
                            <a href="" class="btn btn-xs edit-link">
                                &times;
                            </a>
                        <?php endif ?>
                    </div>
                </div>
                <div class="comment-content">
                    <blockquote>
                        <?= $comment->text ?>
                    </blockquote>
                </div>
    
                <div class="comment-footer">
                   
                </div>
            </div>

        <?php endforeach?>
    <?php endif ?>
<?php endif ?>