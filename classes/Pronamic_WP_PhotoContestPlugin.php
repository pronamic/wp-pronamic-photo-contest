<?php

class Pronamic_WP_PhotoContestPlugin {
	/**
	 * The main plugin file
	 *
	 * @var string
	 */
	public $file;

	/**
	 * Constructs and intializes an Pronamic Post Like plugin
	 *
	 * @param string $file
	 */
	public function __construct( $file ) {
		$this->file = $file;
		$this->path = plugin_dir_path( $file );

		require_once $this->path . 'includes/functions.php';
		require_once $this->path . 'includes/gravityforms.php';
		require_once $this->path . 'includes/post.php';

		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );

		add_action( 'init', array( $this, 'init' ) );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Admin
		if ( is_admin() ) {
			new Pronamic_WP_PhotoContestPlugin_Admin( $this );
		}
	}

	/**
	 * Plugins loaded
	 */
	public function plugins_loaded() {
		load_plugin_textdomain( 'pronamic_photo_contest', false, dirname( plugin_basename( $this->file ) ) . '/languages/' );
	}

	/**
	 * Initialize
	 */
	public function init() {
		register_post_type( 'pronamic_photo_conte', array(
			'labels'             => array(
				'name'               => _x( 'Photo Contests', 'post type general name', 'pronamic_photo_contest' ),
				'singular_name'      => _x( 'Photo Contest', 'post type singular name', 'pronamic_photo_contest' ),
				'add_new'            => _x( 'Add New', 'pronamic_photo_contest', 'pronamic_photo_contest' ),
				'add_new_item'       => __( 'Add New Photo Contest', 'pronamic_photo_contest' ),
				'edit_item'          => __( 'Edit Photo Contest', 'pronamic_photo_contest' ),
				'new_item'           => __( 'New Photo Contest', 'pronamic_photo_contest' ),
				'view_item'          => __( 'View Photo Contest', 'pronamic_photo_contest' ),
				'search_items'       => __( 'Search Photo Contests', 'pronamic_photo_contest' ),
				'not_found'          => __( 'No photo contests found', 'pronamic_photo_contest' ),
				'not_found_in_trash' => __( 'No photo contests found in Trash', 'pronamic_photo_contest' ),
				'parent_item_colon'  => __( 'Parent Photo Contest:', 'pronamic_photo_contest' ),
				'menu_name'          => __( 'Photo Contest', 'pronamic_photo_contest' )
			),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => _x( 'photo-contests', 'URL slug', 'pronamic_photo_contest' ) ),
			'menu_icon'          => plugins_url( 'admin/images/camera.png', $this->file ),
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields' )
		) );

		register_post_type( 'pronamic_photo_entry', array(
			'labels'             => array(
				'name'               => _x( 'Photo Entries', 'post type general name', 'pronamic_photo_contest' ),
				'singular_name'      => _x( 'Photo Entry', 'post type singular name', 'pronamic_photo_contest' ),
				'add_new'            => _x( 'Add New', 'pronamic_photo_entry', 'pronamic_photo_contest' ),
				'add_new_item'       => __( 'Add New Photo Entry', 'pronamic_photo_contest' ),
				'edit_item'          => __( 'Edit Photo Entry', 'pronamic_photo_contest' ),
				'new_item'           => __( 'New Photo Entry', 'pronamic_photo_contest' ),
				'view_item'          => __( 'View Photo Entry', 'pronamic_photo_contest' ),
				'search_items'       => __( 'Search Photo Entries', 'pronamic_photo_contest' ),
				'not_found'          => __( 'No photo entries found', 'pronamic_photo_contest' ),
				'not_found_in_trash' => __( 'No photo entries found in Trash', 'pronamic_photo_contest' ),
				'parent_item_colon'  => __( 'Parent Photo Entry:', 'pronamic_photo_contest' ),
				'menu_name'          => __( 'Entries', 'pronamic_photo_contest' )
			),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'edit.php?post_type=pronamic_photo_conte',
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => _x( 'photo-entries', 'URL slug', 'pronamic_photo_contest' ) ),
			'menu_icon'          => plugins_url( 'admin/images/camera.png', $this->file ),
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields' )
		) );
	}
	
	public function enqueue_scripts() {
		wp_register_style( 'pronamic-photo-contest', plugins_url( 'includes/css/style.css', $this->file ), false, '1.0.0' );
	}
}
