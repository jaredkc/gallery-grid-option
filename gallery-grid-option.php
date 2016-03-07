<?php
/**
 * @category     WordPress_Plugin
 * @package      Gallery_Grid_Option
 * @author       Jared Cornwall
 * @license      GPL-2.0+
 *
 * Plugin Name:  Gallery Grid Option
 * Plugin URI:   https://github.com/jaredkc/wp-gallery-grid-option
 * Description:  Extends the default WordPress [gallery] shortcode. Adds settings to display the gallery short code as an image grid (Masonry grid layout). Meta data setting added to images for display size (small or large). Gallery setting added to set grid display or default WordPress gallery.
 * Author:       Jared Cornwall
 * Author URI:   http://jaredcornwall.com
 *
 * Version:      0.1
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 */

add_action( 'admin_init', array( Gallery_Grid_Option::get_instance(), 'init_plugin' ), 20 );
class Gallery_Grid_Option {
	/**
	 * Stores the class instance.
	 *
	 * @var Gallery_Grid_Option
	 */
	private static $instance = null;


	/**
	 * Returns the instance of this class.
	 *
	 * It's a singleton class.
	 *
	 * @return Gallery_Grid_Option The instance
	 */
	public static function get_instance() {

		if ( ! self::$instance )
			self::$instance = new self;

		return self::$instance;
	}

	/**
	 * Initialises the plugin.
	 */
	public function init_plugin() {

		$this->init_hooks();
	}

	/**
	 * Initialises the WP actions.
	 *  - admin_print_scripts
	 */
	private function init_hooks() {

		add_action( 'wp_enqueue_media', array( $this, 'wp_enqueue_media' ) );
		add_action( 'print_media_templates', array( $this, 'print_media_templates' ) );
	}


	/**
	 * Enqueues the script.
	 */
	public function wp_enqueue_media() {
		if ( ! isset( get_current_screen()->id ) || get_current_screen()->base != 'post' )
			return;

		wp_enqueue_script(
			'gallery-grid-option-settings',
			plugins_url( 'js/custom-gallery-setting.js', __FILE__ ),
			array( 'media-views' )
		);


	}

	/**
	 * Outputs the view template with the custom setting.
	 */
	public function print_media_templates() {

		if ( ! isset( get_current_screen()->id ) || get_current_screen()->base != 'post' )
			return;

		?>
		<script type="text/html" id="tmpl-custom-gallery-setting">
			<label class="setting">
				<span>Style</span>
				<select class="type" name="style" data-setting="style">
					<?php

					$styles = apply_filters( 'image_style_names_choose', array(
						'default' => __( 'Default' ),
						'grid'    => __( 'Grid' ),
					) );

					foreach ( $styles as $value => $name ) { ?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, 'default' ); ?>>
							<?php echo esc_html( $name ); ?>
						</option>
					<?php } ?>
				</select>
			</label>
			<small>Note: Masonry style gallery grid option only works with 2, 3, or 4 column grids. Any other column setting will default to 2 column grids. Use the "Display Size" option for each image to build your gallery. The "Default" style option will inherit your themes display for WP galleries.</small>
		</script>
		<?php
	}

}

require_once 'inc/add-image-meta.php';
require_once 'inc/display-gallery-grid.php';


add_action( 'wp_enqueue_scripts', 'gg_scripts' );
function gg_scripts() {

	wp_enqueue_style(
		'gg-css', plugins_url( 'css/gallery-grid.css', __FILE__ )
	);

	wp_enqueue_script(
		'gg-imagesloaded',
		plugins_url( 'js/imagesloaded.pkgd.min.js', __FILE__ )
	);

	wp_enqueue_script(
		'gg-masonry',
		plugins_url( 'js/masonry.pkgd.min.js', __FILE__ )
	);

	wp_enqueue_script(
		'gg-js',
		plugins_url( 'js/gallery-grid.js', __FILE__ ),
		array( 'imagesloaded', 'masonry' )
	);

}
