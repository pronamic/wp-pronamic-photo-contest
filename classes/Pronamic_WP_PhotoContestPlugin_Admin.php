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
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		add_action( 'save_post',   array( $this, 'save_photo_contest' ), 10, 2 );
		add_action( 'save_post',   array( $this, 'save_photo_entry' ), 10, 2 );
	}

	//////////////////////////////////////////////////

	/**
	 * Add meta boxes
	 */
	function add_meta_boxes() {
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
	function photo_contest_details_meta_box( $post ) {
		include $this->plugin->path . '/admin/meta-box-photo-contest-details.php';
	}

	/**
	 * Photo contest meta box
	 * 
	 * @param WP_Post $post
	 */
	function photo_contest_entries_meta_box( $post ) {
		include $this->plugin->path . '/admin/meta-box-photo-contest-entries.php';
	}

	/**
	 * Photo entry meta box
	 * 
	 * @param WP_Post $post
	 */
	function photo_entry_details_meta_box( $post ) {
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
	function save_photo_contest( $post_id, $post ) {
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
	function save_photo_entry( $post_id, $post ) {
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
}
