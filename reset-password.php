<?php

	// register form submitted
	if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
	{
        $access_key = $_POST['access_key'];
        $password = $_POST['password'];
        $password_repeat = $_POST['password_repeat'];

		$reset = $auth->resetPass( $access_key, $password, $password_repeat );

		if ( $reset['error'] ) {
			flash()->error( $reset['message'] );
		}
		else {
			flash()->success('Thank you, try do not forget now. Now you can login.');
			redirect('/login');
		}
	}

	include_once "_partials/header.php";

?>

	<form method="post" action="" class="box box-auth">
		<h2 class="box-auth-heading">
			Activate your f*#@$g account, you muggle
		</h2>

        <input type="text" value="<?= $_POST['access_key'] ?: '' ?>" class="form-control" name="access_key" placeholder="Enter your activation key" required autofocus>
        <input type="password" class="form-control" name="password" placeholder="Password" required>
		<input type="password" class="form-control" name="password_repeat" placeholder="Password again, DO IT" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit">eat snails</button>

		<p class="alt-action text-center">
			or <a href="<?= BASE_URL ?>/login">come inside (of me)</a>
		</p>
	</form>

<?php include_once "_partials/footer.php" ?>