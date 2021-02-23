<?php
/*
Plugin Name: CMB2 Radio Image
Description: https://github.com/satwinderrathore/CMB2-Radio-Image/
Version: 0.1
Author: Satwinder Rathore
Author URI: http://satwinderrathore.wordpress.com
License: GPL-2.0+
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Class CMB2_Radio_Image
 */
class CMB2_Radio_Image {

	public function __construct() {
		add_action( 'cmb2_render_radio_image', array( $this, 'callback' ), 10, 5 );
		add_filter( 'cmb2_list_input_attributes', array( $this, 'attributes' ), 10, 4 );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
	}

	public function callback( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
		echo $field_type_object->radio();
	}


	public function attributes( $args, $defaults, $field, $cmb ) {
		if ( $field->args['type'] !== 'radio_image' || empty( $field->args['images'] ) ) {
			return $args;
		}

		if ( empty( $field->args['images'][ $args['value'] ] ) ) {
				return $args;
		}

		$path = $field->args['images_path'] ?: plugin_dir_url( __FILE__ );

		$image = trailingslashit( $path ) . $field->args['images'][ $args['value'] ];
		$args['label'] = sprintf(
				'<img src="%1$s" alt="%2$s" />',
				esc_url( $image ),
				esc_attr( $args['label'] )
		);

		$args['class'] = 'screen-reader-text';

		return $args;
	}


	public function admin_head() {
		?>
		<style>
			.cmb-type-radio-image .cmb2-radio-list {
				display: block;
				clear: both;
				overflow: hidden;
			}

			.cmb-type-radio-image li {
				display: inline-block;
				margin: 0 .5em;
			}

			.cmb-type-radio-image input[type="radio"] + label {
				display: block;
				padding: .25em;
				border: 3px solid #eee;
			}

			.cmb-type-radio-image input[type="radio"] + label:hover,
			.cmb-type-radio-image input[type="radio"]:focus + label,
			.cmb-type-radio-image input[type="radio"]:checked + label {
				border-color: #5b9dd9;
			}

			.cmb-type-radio-image label img {
				display: block;
			}
		</style>
		<?php
	}
}

$cmb2_radio_image = new CMB2_Radio_Image();
