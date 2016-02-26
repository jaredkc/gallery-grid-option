<?php
/**
 * Add Image Size meta data option to media so we can set image size to display.
 *
 * Reference link used to create this:
 * http://www.billerickson.net/wordpress-add-custom-fields-media-gallery/
 *
 * @param $form_fields array, fields to include in attachment form
 * @param $post object, attachment record in database
 * @return $form_fields, modified form fields
 */
function image_size_field( $form_fields, $post ) {

	// Set up options
	$options = array(
		'gg-size-sm' => 'Small',
		'gg-size-lg' => 'Large',
	);

	// Get currently selected value
	$selected = get_post_meta( $post->ID, '_grid_image_size', true );

	// Display each option
	foreach ( $options as $value => $label ) {
		$checked = '';
		$css_id = 'image-include-option-' . $value;

		if ( $selected == $value ) {
			$checked = " checked='checked'";
		}

		$html  = "<span class='image-include-option' style='margin-right:5px;'>";
		$html .= "<input type='radio' name='attachments[$post->ID][grid-image-include]' id='{$css_id}' value='{$value}'$checked />";
		$html .= "<label for='{$css_id}' style='display:inline-block; margin:8px 0 0 3px;'>$label</label>";
		$html .= '</span>';

		$out[] = $html;
	}

	// Construct the form field
	$form_fields['grid-include-image'] = array(
		'label' => 'Grid Display Size',
		'input' => 'html',
		'html'  => join("\n", $out),
	);

	// Return all form fields
	return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'image_size_field', 10, 2 );


/**
 * Save value of display size in media editor
 *
 * @param $post array, the post data for database
 * @param $attachment array, attachment fields from $_POST form
 * @return $post array, modified post data
 */
function image_size_field_save( $post, $attachment ) {
	if( isset( $attachment['grid-image-include'] ) )
		update_post_meta( $post['ID'], '_grid_image_size', $attachment['grid-image-include'] );

	return $post;
}
add_filter( 'attachment_fields_to_save', 'image_size_field_save', 10, 2 );
