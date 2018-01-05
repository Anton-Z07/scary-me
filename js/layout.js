var l = console.log.bind(console);
var image_viewer_current_gallery = false;

$(function(){
	initGallery();
	$('img.viewable').each(function(){
		$(this).click(function(){ ViewFullImage(this); });
	});
	$('#modal-shadow').click(HideImageViewer);
});

function initGallery()
{
	$('.gallery').each(function(){
		if ($(this).find('.images .active').size() == 0)
			$(this).find('.images img').first().addClass('active');
		$(this).find('.viewport img').attr( 'src', $(this).find('.images .active').attr('src') );
		GalleryAdjust($(this));
		var gal = $(this);
		$(this).find('.viewport .nav-button').click(function(){
			var new_active;
			if ($(this).index() == 0) {
				if ( gal.find('.active').prev().size() )
					new_active = gal.find('.active').prev();
				else
					new_active = gal.find('.images img').last();
			} else {
				if ( gal.find('.active').next().size() )
					new_active = gal.find('.active').next();
				else
					new_active = gal.find('.images img').first();
			}
			gal.find('.active').removeClass('active');
			new_active.addClass('active');
			gal.find('.viewport img').attr('src', new_active.attr('src'));
			GalleryAdjust(gal);
		});
	});
}

function GalleryAdjust(gal)
{
	var MIN_WIDTH = 100;
	var width = (gal.find('.viewport').width() - gal.find('.viewport img').width()) / 2;
	if (width < MIN_WIDTH) width = MIN_WIDTH;
	gal.find('.viewport .nav-button').css('width', width);

	gal.find('.counter').text( (gal.find('.active').index()+1) + ' of ' + gal.find('.images img').size() );
	gal.find('.caption').text( gal.find('.active').attr('alt') );
}

function ViewFullImage(img)
{
	if ($(img).parent().hasClass('viewport')) image_viewer_current_gallery = $(img).closest('.gallery');
	else image_viewer_current_gallery = false;

	if (!$('#image-viewer').size())
		$('body').append('<img id="image-viewer" onclick="onViewerClick();"/>');
	$('#image-viewer').attr('src', $(img).attr('src'));
	$('#image-viewer').hide();
	$('#modal-shadow').fadeIn(300);
	$('#image-viewer').fadeIn(300);
}

function HideImageViewer()
{
	if (!$('#image-viewer').is(':visible')) return;
	$('#modal-shadow').fadeOut(300);
	$('#image-viewer').fadeOut(300);
}

function onViewerClick()
{
	if (!image_viewer_current_gallery) return;
	l(image_viewer_current_gallery);
	image_viewer_current_gallery.find('.next').click();
	$('#image-viewer').attr('src', image_viewer_current_gallery.find('.viewport img').attr('src'));
}