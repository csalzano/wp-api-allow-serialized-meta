<?php
/**
 * Plugin Name: WP REST API - Allow Serialized Meta Values
 * Plugin URI: https://github.com/mistercorey/
 * Description: Modify the behavior of my forked version of the `WP REST API - Meta Endpoints` plugin to allow authenticated users access to serialized meta data via the REST API.
 * Version: 1.0.0
 * Author: Corey Salzano
 * Author URI: https://profiles.wordpress.org/salzano
 * Text Domain: rest-allow-serialized-meta-values
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) OR exit;

function rest_allow_serialized_meta_for_authenticated_users( $value, $meta_value, $request ) {
	if( ! is_serialized( $meta_value ) ) {
		return $value;
	}

	$parent = get_post( (int) $request['parent_id'] );
	$post_type = get_post_type_object( $parent->post_type );

	return current_user_can( $post_type->cap->edit_post, $parent->ID );
}
add_filter( 'rest_is_valid_meta_data', 'rest_allow_serialized_meta_for_authenticated_users', 10, 3 );
