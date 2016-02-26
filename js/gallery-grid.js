/**
 * Trigger Masonry for image gallery layout
 * after Images have loaded.
 */
imagesLoaded( '.gg-gallery', function() {
	var msnry = new Masonry( '.gg-gallery', {
		itemSelector: '.gg-masonry',
		columnWidth: '.gg-sizer',
		gutter: '.gg-gutter'
	});
});

