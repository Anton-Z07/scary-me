<style>
	.movies {
		margin-top: 40px;
	}
	ul.movies li {
		display: inline-block;
		width: 33%;
	}
	form * {
		display: block;
		width: 100%;
		box-sizing: border-box;
		margin-bottom: 5px;
	}
</style>

<form action="/admin/movies/add" method="POST">
	<input type="text" name="imdb" placeholder="IMDB link" />
	<input type="text" name="image" placeholder="image link" />
	<button type="submit" class="btn btn-red">Submit</button>
</form>
<div><?= U::gp('msg'); ?></div>

<ul class="movies">
	<? foreach ($movies as $movie) 
		echo "<li><a href='{$movie->image}'>$movie->name ({$movie->release_year})</a></li>"; ?>
</ul>