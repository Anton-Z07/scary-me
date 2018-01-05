<? $this->js[] = '/js/random-movie.js'; ?>

<article class="post">
	<div id="year-range">
		<div class="year-range-labels"></div>
		<div class="year-range-touchzone">
			<div class="year-range-line"></div>
			<div class="year-range-pointers">
				<div class="year-pointer-filling"></div>
				<span class="year-range-pointer p-left" style="left:0%;" draggable="true" ondrag="onPointerDrag(this, event);"></span>
				<span class="year-range-pointer p-right" style="left:100%;" draggable="true" ondrag="onPointerDrag(this, event);"></span>
			</div>
		</div>
	</div>
	<button class="btn btn-red btn-block" onclick="getRandomMovie();">Random horror movie</button>
	<div id="random_movie">
		<div class="title"><a href="" class="no-dec" target="_blank" id="imdb-link"><span data-id="name"></span> (<span  data-id="release_year"></span>)</a></div>
		<i data-id="director"></i>
		<div class="viewport light">
			<img class="noselect" src="" id="image" />
		</div>
	</div>
</article>
