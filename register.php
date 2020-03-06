<?php

	// register form submitted
	if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
	{
		$email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL );
		$username = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );
		$password = $_POST['password'];
		$password_repeat = $_POST['repeat'];

		$register = $auth->register( $email, $username, $password, $password_repeat );

		if ( $register['error'] ) {
			flash()->error( $register['message'] );
		}
		else {
			flash()->success('Welcome! Now enter the same shit into a new form!');
			redirect('/activate');
		}
	}

	include_once "_partials/header.php";

?>

	<form method="post" action="" class="box box-auth">
		<h2 class="box-auth-heading">
			Register, you dumbass
		</h2>

		<input type="text" name="username" id="username" class="form-control" placeholder="Nickname" required autofocus>
		<input type="text" value="<?= $_POST['email'] ?: '' ?>" class="form-control" name="email" placeholder="Email Address" required>
		<input type="password" class="form-control" name="password" placeholder="Password" required>
		<input type="password" class="form-control" name="repeat" placeholder="Password again, DO IT" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>

		<p class="alt-action text-center">
			or <a href="<?= BASE_URL ?>/login">come inside (of me)</a>
		</p>
	</form>

<?php include_once "_partials/footer.php" ?>