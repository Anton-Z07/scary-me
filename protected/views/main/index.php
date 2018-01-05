<ul class="flex-card-list">
	<? foreach ($posts as $post): ?>
	<li class="flex-card-listitem"><article class="post-main">
		<div class="image-box">
			<a href="/p/<?=$post->url; ?>"><img src="<?= $post->image; ?>"></a>
		</div>
		<div class="theme"><?= $post->theme; ?>
			<span><?= $post->getDate(); ?></span>
		</div>
		<h2><a href="/p/<?=$post->url; ?>"><?= $post->title; ?></a></h2>
		<p><?= $post->short_text; ?></p>
	</article></li>
	<? endforeach; ?>
</ul>
<div class="nav-buttons noselect">
	<a href="<?=$prev_link;?>" class="no-dec hvr-rectangle-out <?=$previous===false?'hid':'';?>">Previous page</a> <span>|</span>
	<a href="?page=<?=$next;?>" class="no-dec hvr-rectangle-out <?=$next===false?'hid':'';?>">Next page</a>
</div>