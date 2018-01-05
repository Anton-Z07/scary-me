<article class="post">
	<div class="theme"><?= $post->theme; ?>
		<span><?= $post->getDate(); ?></span>
	</div>
	<h1><?= $post->title; ?></h1>

	<? if ($post->theme == 'gallery'): ?>
		<div class="gallery">
			<div class="images">
				<? foreach ($post->images as $img): ?>
					<img src="<?= $img->path; ?>" alt="<?= $img->caption; ?>" />
				<? endforeach; ?>
			</div>
			<div class="viewport">
				<div class="nav-button">
					<i class="fa fa-angle-left" aria-hidden="true"></i>
				</div>
				<img class="noselect viewable" />
				<div class="nav-button next">
					<i class="fa fa-angle-right" aria-hidden="true"></i>
				</div>
			</div>
			<div class="counter">1 of 1</div>
			<div class="caption"></div>
		</div>
	<? endif; ?>

	<div><?= $post->text; ?></div>
</article>
<div class="sidebar">
	<div>See also</div>
	<? foreach ($recommended as $post): ?>
		<article class="recommended">
			<a href="/p/<?=$post->url; ?>"><img src="<?= $post->small_image; ?>"></a>
			<a href="/p/<?=$post->url; ?>" class="title"><?= $post->title; ?></a>
		</article>
	<? endforeach; ?>
</div>