$(function(){
	initYearRange();
	getRandomMovie();
});

function getRandomMovie() {
	//$('#random_movie').fadeOut(200);
	$.getJSON('/random/movie/get',{from:$('.p-left').attr('data-year'),to:$('.p-right').attr('data-year')}, function(data){
		for (i in data)
			$('[data-id='+i+']').text( data[i] );
		$('#imdb-link').attr('href', data['imdb_link']);
		$('#image').attr('src', data['image']);
		//$('#random_movie').fadeIn(200);
		$('#random_movie').show();
	});
}

function initYearRange() {
	var range = $('#year-range');
	var min_year = 1960;
	var max_year = new Date().getFullYear();
	range.attr('data-min', min_year);
	range.attr('data-max', max_year);
	range.find('.p-left').attr('data-year',min_year);
	range.find('.p-right').attr('data-year',max_year);
	var years = max_year - min_year;
	for (var i=0; i<=years; i++) {
		var pos = Math.round(100*i/years)+'%';
		if (i % 10 == 0 || i == years) {
			range.find('.year-range-labels').append( $('<span class="year-range-label">'+(i+min_year)+'</span>').css('left', pos) );
			range.find('.year-range-line').append( $('<span class="year-range-dash"></span>').css('left', pos) );
		}
		if (i % 5 == 0 && i % 10 != 0)
			range.find('.year-range-line').append( $('<span class="year-range-dash sub"></span>').css('left', pos) );
	}
	$('.year-range-touchzone').click(function(e){
		var x = e.pageX;
		if (x >= $('.p-right').offset().left)
			movePointer($('.p-right'), e.pageX);
		else
			movePointer($('.p-left'), e.pageX);
	});
	$('.year-range-pointer').on("touchmove", function(e){ movePointer(this, e.originalEvent.touches[0].clientX); });
}

function onPointerDrag(p, e) {
	movePointer(p, e.x);
}

function movePointer(p, x) {
	var left = $(p).parent().position().left;
	var right = left + $(p).parent().width();
	var other_pointer = $(p).hasClass('p-left') ? $(p).next() : $(p).prev();
	if (x == 0) return;
	if (x > right) x = right;
	if (x < left) x = left;
	if ($(p).hasClass('p-left') && x > (left+other_pointer.position().left)) return;
	if ($(p).hasClass('p-right') && x < (left+other_pointer.position().left)) return;
	x -= left;
	var pc = x / $('#year-range').width();
	var years = $('#year-range').attr('data-max')-$('#year-range').attr('data-min');
	var year = Math.round( pc * years );
	var pos = Math.round(100 * year / years) + '%';
	$(p).attr('data-year', year + parseInt($('#year-range').attr('data-min')));
	$(p).css('left', pos);
	updatePointers();
}

function updatePointers() {
	var left = parseInt($('.year-range-pointer.p-left').get(0).style.left);
	var right = parseInt($('.year-range-pointer.p-right').get(0).style.left);
	var width = right - left + 0.2;
	$('.year-pointer-filling').css('left', left + '%');
	$('.year-pointer-filling').css('width', width + '%');
}