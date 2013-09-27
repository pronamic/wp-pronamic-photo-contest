<?php

class Pronamic_WP_PhotoContestPlugin_Admin {
	/**
	 * The plugin
	 *
	 * @var string
	 */
	private $plugin;

	/**
	 * Constructs and intializes an Pronamic Post Like plugin
	 *
	 * @param string $file
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;

		// Actions
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		add_action( 'save_post',   array( $this, 'save_photo_contest' ), 10, 2 );
		add_action( 'save_post',   array( $this, 'save_photo_entry' ), 10, 2 );
	}

	//////////////////////////////////////////////////
	
	/**
	 * Admin init
	 */
	public function admin_init() {

		// Settings
		add_settings_section(
			'pronamic_photo_contest_general', // id
			__( 'General', 'pronamic_photo_contest' ), // title
			array( $this, 'settings_section' ), // callback
			'pronamic_photo_contest' // page
		);
		
		add_settings_field(
			'pronamic_photo_contest_gf_submit_form_id', // id
			__( 'Gravity Forms submit form', 'pronamic_photo_contest' ), // title
			array( __CLASS__, 'dropdown_gf_forms' ), // callback
			'pronamic_photo_contest', // page
			'pronamic_photo_contest_general', // section
			array( 'label_for' => 'pronamic_photo_contest_gf_submit_form_id' ) // args
		);

		// Register settings
		register_setting( 'pronamic_photo_contest', 'pronamic_photo_contest_gf_submit_form_id' );
	}

	//////////////////////////////////////////////////
	
	/**
	* Admin menu
	*/
	public function admin_menu() {
		add_submenu_page(
			'edit.php?post_type=pronamic_photo_conte', // parent_slug
			__( 'Photo Contest Settings', 'pronamic_photo_contest' ), // page_title
			__( 'Settings', 'pronamic_photo_contest' ), // menu_title
			'read', // capability
			'pronamic_photo_contest_settings', // menu_slug
			array( $this, 'page_settings' ) // function
		);
	}

	//////////////////////////////////////////////////

	/**
	 * Enqueue scripts
	 */
	public function enqueue_scripts() {
		wp_register_style( 'pronamic-photo-contest', plugins_url( 'admin/css/style.css', $this->plugin->file ), false, '1.0.0' );
	}

	//////////////////////////////////////////////////

	/**
	 * Add meta boxes
	 */
	public function add_meta_boxes() {
		add_meta_box(
			'pronamic_photo_contest_details',
			__( 'Details', 'pronamic_photo_contest' ),
			array( $this, 'photo_contest_details_meta_box' ),
			'pronamic_photo_conte',
			'normal',
			'high'
		);

		add_meta_box(
			'pronamic_photo_contest_entries',
			__( 'Entries', 'pronamic_photo_contest' ),
			array( $this, 'photo_contest_entries_meta_box' ),
			'pronamic_photo_conte',
			'normal',
			'high'
		);

		add_meta_box(
			'pronamic_photo_entry_details',
			__( 'Photo Entry', 'pronamic_photo_contest' ),
			array( $this, 'photo_entry_details_meta_box' ),
			'pronamic_photo_entry',
			'normal',
			'high'
		);
	}

	//////////////////////////////////////////////////

	/**
	 * Photo contest meta box
	 * 
	 * @param WP_Post $post
	 */
	public function photo_contest_details_meta_box( $post ) {
		include $this->plugin->path . '/admin/meta-box-photo-contest-details.php';
	}

	/**
	 * Photo contest meta box
	 * 
	 * @param WP_Post $post
	 */
	public function photo_contest_entries_meta_box( $post ) {
		include $this->plugin->path . '/admin/meta-box-photo-contest-entries.php';
	}

	/**
	 * Photo entry meta box
	 * 
	 * @param WP_Post $post
	 */
	public function photo_entry_details_meta_box( $post ) {
		include $this->plugin->path . '/admin/meta-box-photo-entry-details.php';
	}

	//////////////////////////////////////////////////

	/**
	 * Save post meta
	 * 
	 * @param string $post_id
	 * @param array $definition
	 */
	private function save_post_meta( $post_id, $definition ) {
		$data = filter_input_array( INPUT_POST, $definition );
		
		foreach ( $data as $key => $value ) {
			if ( empty( $value ) ) {
				delete_post_meta( $post_id, $key );
			} else {
				update_post_meta( $post_id, $key, $value );
			}
		}
	}

	//////////////////////////////////////////////////

	/**
	 * Save post
	 * 
	 * @param string $post_id
	 * @param WP_Post $post
	 */
	public function save_photo_contest( $post_id, $post ) {
		// Doing autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
	
		// Verify nonce
		$nonce = filter_input( INPUT_POST, 'pronamic_photo_contest_meta_box_nonce', FILTER_SANITIZE_STRING );
		if ( ! wp_verify_nonce( $nonce, 'pronamic_photo_contest_save' ) ) {
			return;
		}
	
		// Check permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	
		// OK
		$definition = array(
			'_pronamic_photo_contest_submit_start_date' => FILTER_SANITIZE_STRING,
			'_pronamic_photo_contest_submit_end_date'   => FILTER_SANITIZE_STRING,
			'_pronamic_photo_contest_vote_start_date'   => FILTER_SANITIZE_STRING,
			'_pronamic_photo_contest_vote_end_date  '   => FILTER_SANITIZE_STRING
		);
	
		$this->save_post_meta( $post_id, $definition );
	}

	//////////////////////////////////////////////////

	/**
	 * Save post
	 * 
	 * @param string $post_id
	 * @param WP_Post $post
	 */
	public function save_photo_entry( $post_id, $post ) {
		// Doing autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
	
		// Verify nonce
		$nonce = filter_input( INPUT_POST, 'pronamic_photo_entry_meta_box_nonce', FILTER_SANITIZE_STRING );
		if ( ! wp_verify_nonce( $nonce, 'pronamic_photo_entry_save' ) ) {
			return;
		}
	
		// Check permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	
		// OK
		$definition = array(
			'_pronamic_photo_contest_id' => FILTER_SANITIZE_STRING
		);
	
		$this->save_post_meta( $post_id, $definition );
	}

	//////////////////////////////////////////////////

	/**
	 * Page settings
	 */
	public function page_settings() {
		include $this->plugin->path . '/admin/settings.php';
	}

	//////////////////////////////////////////////////
	
	/**
	 * Settings section
	 */
	public function settings_section() {
	
	}
	
	/**
	 * Input text
	 *
	 * @param array $args
	 */
	public static function input_text( $args ) {
		printf(
			'<input name="%s" id="%s" type="text" value="%s" class="%s" />',
			esc_attr( $args['label_for'] ),
			esc_attr( $args['label_for'] ),
			esc_attr( get_option( $args['label_for'] ) ),
			'regular-text code'
		);
	}
	
	/**
	 * Dropdown Gravity Forms forms
	 */
	public function dropdown_gf_forms( $args ) {
		$id    = $args['label_for'];
		$name  = $args['label_for'];
		$value = get_option( $args['label_for'] );

		$forms = array();
		
		if ( method_exists( 'RGFormsModel', 'get_forms') ) {
			$forms = RGFormsModel::get_forms();
		}
		
		if ( empty( $forms ) ) {
			_e( 'You don\'t  have any Gravity Forms forms.', 'pronamic_photo_contest' );
		} else {
			printf( '<select name="%s" id="%s">',$name, $id );
			printf( '<option value="%s" %s>%s</option>', '', selected( $value, '', false ), '' );
			foreach ( $forms as $form ) {
				printf( '<option value="%s" %s>%s</option>', $form->id, selected( $value, $form->id, false ), $form->title );
			}
			printf( '</select>' );
		}
	}
}
