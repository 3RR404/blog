<?php

include_once "_partials/header.php";

if ( !can( false, 'user', 'delete' ) ) {
    flash()->error('what are you trying, bro\' ?');
    redirect('/');
}
?>
<section class="box post-list">
    <h1 class="box-heading text-muted">Users </h1>

    
    <table class="table table-bordered table-border-1">
        <thead>
            <th>Username</th>
            <th></th>
            <th>Actions</th>
        </thead>
        <tbody>
            <?php foreach( get_all_users() as $user ) : ?>
            <tr>
                <td>
                    <?= $user->username ?>
                </td>
                <td></td>
                <td>
                    <div class="btn-group">
                        <?php if( can( false, 'user', 'edit' ) ) : ?>

                            <a href="#user-delete" class="btn btn-xs btn-info">Edit</a>
                            
                        <?php endif; ?>
                        <?php if( can( false, 'user', 'delete' ) ) : ?>
    
                            <a href="#user-delete" class="btn btn-xs btn-danger">&times;</a>
                            
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</section>
<?php include_once "_partials/footer.php" ?>