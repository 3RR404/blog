<?php

	// login form submitted
	if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
	{
		$username = filter_var( $_POST['username'], FILTER_SANITIZE_EMAIL );
		$password = $_POST['password'];
		$remember = $_POST['rememberMe'] ? true : false;

		$login = $auth->login( $username, $password, $remember );

		if ( $login['error'] )
		{
			flash()->error( $login['message'] );
		}
		else
		{
			do_login( $login );

			flash()->success('Sup, bro!');
			redirect('/');
		}
	}

	include_once "_partials/header.php";
?>

	<form method="post" action="" class="box box-auth">
		<h2 class="box-auth-heading">
			Login, bitch
		</h2>

		<input type="text" value="<?= $_POST['username'] ?: '' ?>" class="form-control" name="username" placeholder="Email Address" required autofocus>
		<input type="password" class="form-control" name="password" placeholder="Password" required>
		<label class="checkbox">
			<input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe" checked>
			Remember me
		</label>

		<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
		<p class="alt-action text-center">
			or <a href="<?= BASE_URL ?>/register">create acount</a>
		</p>
		<p class="alt-action text-center">
			<a href="<?= BASE_URL ?>/forgot">
				I Forgot my f@*#!$' password
			</a>
		</p>
	</form>

<?php include_once "_partials/footer.php" ?>