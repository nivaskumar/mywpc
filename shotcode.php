<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	add_shortcode('COR', 'courses_shortcode');
	function courses_shortcode($post_id) {

	return ob_get_clean(); 
} ?>