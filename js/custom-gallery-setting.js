/**
 * Custom Gallery Setting
 */
( function( $ ) {
	var media = wp.media;

	// Wrap the render() function to append controls
	media.view.Settings.Gallery = media.view.Settings.Gallery.extend({
		render: function() {
			media.view.Settings.prototype.render.apply( this, arguments );

			// Append the custom template
			this.$el.append( media.template( 'custom-gallery-setting' ) );

			// Save the setting
			media.gallery.defaults.style = 'default';
			this.update.apply( this, ['style'] );
			return this;
		}
	} );
} )( jQuery );