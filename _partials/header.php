<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= isset($page_title) ? "$page_title / " : '' ?>this isn't a blog</title>

	<link rel="stylesheet" href="<?= asset('/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">
	<link rel="stylesheet" href="<?= asset('/css/main.css') ?>">
	<script>
		var baseURL = '<?= BASE_URL ?>';
	</script>
</head>
<body class="<?= segment(1) ? plain(segment(1)) : 'home' ?>">

	<header class="container">
		<?= flash()->display() ?>

		<?php if ( logged_in() ) : $logged_in = get_user() ?>
		<div class="navigation">
			<div class="btn-group btn-group-sm pull-left">
				<a href="<?= BASE_URL ?>" class="btn btn-default"> all posts </a>
				<?php if( can( false, 'post', ['create', 'edit'] ) ) : ?>
					<a href="<?= BASE_URL ?>/user/<?= $logged_in->uid ?>" class="btn btn-default"> my posts </a>
				<?php endif ?>
				<?php if( can( false, 'post', 'create' ) ) : ?>
					<a href="<?= BASE_URL ?>/post/new" class="btn btn-default"> add new post</a>
				<?php endif ?>
			</div>

			<div class="btn-group btn-group-sm ml-5">
				<?php if( can( false, 'tag', ['create', 'edit'] ) ) : ?>
					<a href="<?= BASE_URL ?>/tags" class="btn btn-default"> all tags </a>
				<?php endif ?>

				<?php if( can( false, 'tag', 'create' ) ) : ?>
					<a href="<?= BASE_URL ?>/tag/new" class="btn btn-default"> add new tag</a>
				<?php endif ?>
			</div>

			<div class="btn-group btn-group-sm ml-5">
				<?php if( can( false, 'user', ['view', 'create', 'edit', 'delete'] ) ) : ?>
					<a href="<?= BASE_URL ?>/users" class="btn btn-default"> Users </a>
				<?php endif ?>

				<?php /*if( can( false, 'tag', 'create' ) ) : ?>
					<a href="<?= BASE_URL ?>/tag/new" class="btn btn-default"> add new tag</a>
				<?php endif */?>
			</div>

			<div class="btn-group btn-group-sm pull-right">
				<span class="username small"><?= plain( $logged_in->username ) ?></span>
				<a href="<?= BASE_URL ?>/logout" class="btn btn-default logout">logout</a>
			</div>
		</div>
		<?php endif ?>
	</header>

	<main>
		<div class="container">
