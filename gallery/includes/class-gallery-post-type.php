<?php
//Register Gallery post type

defined( 'ABSPATH' ) || exit;

class Gallery_Post_Type {
	public static function init() {
		
		add_action( 'init', array( __CLASS__, 'register_gallery_taxonomies' ),6 );
		add_action( 'init', array( __CLASS__, 'register_gallery_post' ) ,6);
		
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_gallery_meta_box' ) );

		add_action( 'flush_url_after_register_post_type', array( __CLASS__, 'flush_rewrite_rules' ) );
	
	}
	public static function register_gallery_post() {
		$labels = array(
			'name'               => _x( 'Gallery', 'gallery' ),
			'singular_name'      => _x( 'Gallery',  'gallery' ),
			'menu_name'          => _x( 'Gallery', 'admin menu', 'gallery' ),
			'name_admin_bar'     => _x( 'Gallery', 'add new on admin bar', 'gallery' ),
			'add_new'            => _x( 'Add New', 'Gallery', 'gallery' ),
			'add_new_item'       => __( 'Add New Gallery', 'gallery' ),
			'new_item'           => __( 'New Gallery', 'gallery' ),
			'edit_item'          => __( 'Edit Gallery', 'gallery' ),
			'view_item'          => __( 'View Gallery', 'gallery' ),
			'all_items'          => __( 'All Gallery', 'gallery' ),
			'search_items'       => __( 'Search Gallery', 'gallery' ),
			'parent_item_colon'  => __( 'Parent Gallery:', 'gallery' ),
			'not_found'          => __( 'No Gallery found.', 'gallery' ),
			'not_found_in_trash' => __( 'No Gallery found in Trash.', 'gallery' )
		);

		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'Description.', 'gallery' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'gallery' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title','editor','author','thumbnail','excerpt','comments','custom-fields','image' )
		);

		register_post_type( 'gallery', $args );
		do_action( 'flush_url_after_register_post_type' );
	}

	public static function register_gallery_taxonomies() {


		if ( taxonomy_exists( 'gallery_cat' ) ) {
			return;
		}

		$labels = array(
			'name'           => _x( 'Categories', 'taxonomy general name', 'gallery' ),
			'singular_name'  => _x( 'Category', 'taxonomy singular name', 'gallery' ),
			'search_items'   => __( 'Search Category', 'gallery' ),
			'all_items'      => __( 'All Categories', 'gallery' ),
			'parent_item'    => __( 'Parent Category', 'gallery' ),
			'parent_item_colon' => __( 'Parent Category:', 'gallery' ),
			'edit_item'         => __( 'Edit Category', 'gallery' ),
			'update_item'       => __( 'Update Category', 'gallery' ),
			'add_new_item'      => __( 'Add New Category', 'gallery' ),
			'new_item_name'     => __( 'New Gallery Category', 'gallery' ),
			'menu_name'         => __( 'Category', 'gallery' ),
		);
		$arg = array('hierarchical'      => true,
					'labels'            => $labels,
					'show_ui'           => true,
					'show_in_nav_menus' => true,
					'query_var'         => is_admin(),
					'rewrite'           => true,
					'public'            => true);
		register_taxonomy(
			'gallery_cat',
			array('gallery'),
			apply_filters(
				'taxonomy_args_gallery_type', $arg)
		);
	}
	public static function register_gallery_meta_box()
	{
		add_meta_box( 'gallery-image', __( 'Gallery Images', 'gallery' ), array( __CLASS__, 'display_gallery_meta_box' ), 'gallery' );
	}
	public static function display_gallery_meta_box($post)
	{
		wp_enqueue_media();
		wp_enqueue_style('gallery-images-css',get_stylesheet_directory_uri().'/css/gallery-css.css');
		wp_enqueue_script('image-js',get_stylesheet_directory_uri().'/js/images.js',array('jquery'),true,time());

		echo "<input id='upload_image_button' type='button' class='button' value='". __( 'Upload image' )."' />
			<input type='hidden' name='image_attachment_id' id='image_attachment_id' value='".get_option( 'media_selector_attachment_id' )."'>
				<div class='image-preview-wrapper'>
				<ul id='sortable' class='connectedli'>
				</ul>
				<div class='clear'></div>
					
				</div>";

	}
	public static function flush_rewrite_rules() {
		flush_rewrite_rules();
	}
}
Gallery_Post_Type::init();