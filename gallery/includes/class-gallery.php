<?php
defined( 'ABSPATH' ) || exit;

final class Gallery 
{
	protected static $_instance = null;
 
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		
		$this->includes();
		$this->init_hooks();

		do_action( 'theme_gallery_loaded' );
	}

	private function init_hooks() 
	{
		add_action( 'init', array( $this, 'init' ), 0 );
		//add_action( 'init', array( 'WC_Shortcodes', 'init' ) );
				
	}
	public function init() {
	
		do_action( 'before_gallery_init' );
	
		//$this->load_gallery_textdomain();

		$this->gallery_post = new Gallery_Post_Type();
	}

	public function includes() {
		
		require_once dirname( __FILE__ ) . '/class-gallery-post-type.php';
		add_theme_support( 'post-thumbnails' );	
	}
}
