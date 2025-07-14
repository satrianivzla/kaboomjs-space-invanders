<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Music Anniversaries Blog</title>
	<link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<style type="text/css">
		::selection { background-color: #E13300; color: white; }
		::-moz-selection { background-color: #E13300; color: white; }

		body {
			background-color: #fff;
			margin: 40px;
			font: 13px/20px normal Helvetica, Arial, sans-serif;
			color: #4F5155;
		}

		a {
			color: #003399;
			background-color: transparent;
			font-weight: normal;
			text-decoration: none;
		}

		a:hover {
			 color: #97310e;
		}

		h1 {
			color: #444;
			background-color: transparent;
			border-bottom: 1px solid #D0D0D0;
			font-size: 19px;
			font-weight: normal;
			margin: 0 0 14px 0;
			padding: 14px 15px 10px 15px;
		}

		code {
			font-family: Consolas, Monaco, Courier New, Courier, monospace;
			font-size: 12px;
			background-color: #f9f9f9;
			border: 1px solid #D0D0D0;
			color: #002166;
			display: block;
			margin: 14px 0 14px 0;
			padding: 12px 10px 12px 10px;
		}

		#body {
			margin: 0 15px 0 15px;
			min-height: 96px;
		}

		p {
			margin: 0 0 10px;
			padding:0;
		}

		p.footer {
			text-align: right;
			font-size: 11px;
			border-top: 1px solid #D0D0D0;
			line-height: 32px;
			padding: 0 10px 0 10px;
			margin: 20px 0 0 0;
		}

		#container {
			margin: 10px;
			border: 1px solid #D0D0D0;
			box-shadow: 0 0 8px #D0D0D0;
		}

		.navbar {
			margin-bottom: 20px;
		}
	</style>
</head>
<body>

<div id="container" class="container">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<a class="navbar-brand" href="<?php echo base_url(); ?>">Music Anniversaries</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="<?php echo base_url(); ?>">Home</a>
					</li>
				</ul>
				<ul class="navbar-nav">
					<?php if (isset($user)): ?>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								<?php echo html_escape($user->first_name . ' ' . $user->last_name); ?>
							</a>
							<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
								<li><a class="dropdown-item" href="<?php echo site_url('auth/change_password'); ?>">Change Password</a></li>
								<li><hr class="dropdown-divider"></li>
								<li><a class="dropdown-item" href="<?php echo site_url('auth/logout'); ?>">Logout</a></li>
							</ul>
						</li>
					<?php else: ?>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo site_url('auth/login'); ?>">Login</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</nav>

	<div id="body">
		<h1><?php echo isset($title) ? $title : 'Music Anniversaries Blog'; ?></h1>

		<?php if (isset($message)): // Ion auth uses 'message' for notices ?>
			<div class="alert alert-info" role="alert">
				<?php echo $message; ?>
			</div>
		<?php endif; ?>

		<?php if (isset($error_message)): ?>
			<div class="alert alert-danger" role="alert">
				<?php echo $error_message; ?>
			</div>
		<?php endif; ?>

		<?php
        $grouped_posts = [];
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $date = date('Y-m-d', strtotime($post['created_at']));
                if (!isset($grouped_posts[$date])) {
                    $grouped_posts[$date] = [];
                }
                $grouped_posts[$date][] = $post;
            }
        }
        ?>

        <?php if (!empty($grouped_posts)): ?>
            <?php foreach ($grouped_posts as $date => $daily_posts): ?>
                <h2 class="mt-5 mb-3">Events for <?php echo date('F j, Y', strtotime($date)); ?></h2>
                <hr>
                <?php foreach ($daily_posts as $post): ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo html_escape($post['title_' . $current_lang]); ?></h5>
                            <p class="card-text"><?php echo word_limiter(strip_tags($post['content_' . $current_lang]), 40); ?></p>
                            <a href="<?php echo site_url($current_lang . '/posts/view/' . $post['slug']); ?>" class="btn btn-primary">Read More &rarr;</a>
                        </div>
                        <div class="card-footer text-muted">
                            Posted by <?php echo html_escape($post['first_name'] . ' ' . $post['last_name']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
		<?php elseif (!isset($error_message)): ?>
			<div class="alert alert-info" role="alert">
				No anniversaries found or could not be retrieved at this time. The parsing logic in the model might need adjustment based on the blog's current HTML structure.
			</div>
			<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="https://codeigniter.com/userguide3/">User Guide</a>.</p>
		<?php endif; ?>

		<hr>
		<p><em><small>Data scraped from efemeridesrockmetal.blogspot.com</small></em></p>

	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

<script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
</body>
</html>
