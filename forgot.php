<?php 

    if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
    {
        $email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL );

        $resetPass = $auth->requestReset( $email );

		if ( $resetPass['error'] ) {
			flash()->error( $resetPass['message'] );
		}
		else {
			flash()->success('Reset link was sent on your e-mail');
			redirect('/reset');
		}
    }

    include_once "_partials/header.php";
?>

<form method="post" action="" class="box box-auth">
    <h2 class="box-auth-heading">
        Reset 
    </h2>

    <input type="text" value="<?= $_POST['email'] ?: '' ?>" class="form-control" name="email" placeholder="Enter email, where send reset link" required autofocus>
    
    <button class="btn btn-lg btn-primary btn-block" type="submit">Reset</button>

    <p class="alt-action text-center">
		if you have a acc, <a href="<?= BASE_URL ?>/register">create it</a>
    </p>
        
    <p class="alt-action text-center">
        or <a href="<?= BASE_URL ?>/login">come inside (of me)</a>
    </p>
</form>
    
<?php include_once "_partials/footer.php" ?>