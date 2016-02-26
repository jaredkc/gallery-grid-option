<?php
/**
 * Output the front end display of the gallery if set to grid.
 *
 * @param string $output   The gallery output. Default empty.
 * @param array  $attr     Attributes of the gallery shortcode.
 */
function print_gallery_grid($string, $attr) {

	if ( !isset( $attr['style'] ) || $attr['style'] != 'grid' ) {
		return;
	}

	$images = get_posts(array(
		'include' => $attr['ids'],
		'post_type' => 'attachment',
		'orderby' => 'post__in'
	));

	$output = '<ul class="gg-gallery"><li class="gg-sizer"></li><li class="gg-gutter"></li>';

	foreach($images as $imagePost) {
		$size = get_post_meta( $imagePost->ID, '_grid_image_size', true );
		$output .= '<li class="gg-masonry '. $size .'">';
		if ( $size == 'gg-size-lg' ) {
			$output .= wp_get_attachment_image($imagePost->ID, 'large');
		} else {
			$output .= wp_get_attachment_image($imagePost->ID, 'medium');
		}
		$output .= '</li>';
	}

	$output .= '</ul><!-- .gg-gallery -->';

	return $output;
}
add_filter('post_gallery','print_gallery_grid', 10, 2);
