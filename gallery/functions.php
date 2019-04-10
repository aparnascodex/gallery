<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


if ( ! class_exists( 'Gallery' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-gallery.php';
}
Gallery::instance();