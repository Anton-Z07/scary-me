<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?= $this->description; ?>">
	<meta name="keywords" content="<?= $this->keywords; ?>">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link href="/css/all.min.css" rel="stylesheet">
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
	<? if ($_SERVER['HTTP_HOST'] == 'canyouscare.me'): ?>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-77479235-1', 'auto');
		  ga('send', 'pageview');

		</script>
	<? endif; ?>
</body>
</html>