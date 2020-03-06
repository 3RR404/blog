<?php

	// register form submitted
	if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
	{
		$access_key = $_POST['access_key'];

		$activate = $auth->activate( $access_key );

		if ( $activate['error'] ) {
			flash()->error( $activate['message'] );
		}
		else {
			flash()->success('Welcome! Now enter the same shit into a new form!');
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
		<button class="btn btn-lg btn-primary btn-block" type="submit">eat snails</button>

		<p class="alt-action text-center">
			or <a href="<?= BASE_URL ?>/login">come inside (of me)</a>
		</p>
	</form>

<?php include_once "_partials/footer.php" ?>