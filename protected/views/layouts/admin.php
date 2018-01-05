<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?= $this->description; ?>">
	<meta name="keywords" content="<?= $this->keywords; ?>">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link href="/css/all.css" rel="stylesheet">
</head>
<body>
	<div id="page">
		<header>
			<a href="/">CanYouScare.Me</a>
		</header>
		<div id="content">
			<?php echo $content; ?>
		</div>
	</div>
	<footer>
		<p><?= date('Y'); ?> Canyouscare.me</p>
		contact@canyouscare.me
	</footer>
	<div id="modal-shadow"></div>
	<link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
	<script src="/js/jquery/jquery.min.js"></script>
	<script src="/js/layout.js"></script>
	<? foreach ($this->js as $js) echo "<script src='{$js}'></script>"; ?>
</body>
</html>