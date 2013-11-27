<?php

class Pronamic_WP_PhotoContestPlugin_LatestEntriesWidget extends WP_Widget {
	
	/** Plugin reference. */
	protected $plugin;
	
	/** Latest entry ID. */
	protected $latest_entry_ID = -1;
	
	/** The name of this widget. */
	protected $widget_name;
	
	/**
	 * Constructor
	 * 
	 * @param $plugin
	 */
	public function Pronamic_WP_PhotoContestPlugin_LatestEntriesWidget( ) {
		global $pronamic_photo_contest_plugin;
		
		$this->plugin = $pronamic_photo_contest_plugin;
		
		$this->widget_name = __( 'Latest Entries Widget', 'pronamic_photo_contest' );
		
		parent::__construct(
			false,
			$this->widget_name,
			array (
				'classname'   => __CLASS__,
				'description' => __( 'Shows the latest entry of a photo contest.', 'pronamic_photo_contest' )
			)
		);
	}
	
	//////////////////////////////////////////////////

	/**
	 * @see WP_Widget::widget()
	 */
	public function widget( $args, $instance ) {
		$data = new stdClass();
		
		if ( isset( $instance[ 'title' ] ) ) {
			$data->title = $instance[ 'title' ];
		}
		else
		{
			$data->title = '';
		}
		
		if ( isset( $instance[ 'contest_ID' ] ) &&
			 is_numeric( $instance[ 'contest_ID' ] ) ) {
			 $contest_ID = intval( $instance[ 'contest_ID' ] );
		}
		else {
			$contest_ID = $this->latest_entry_ID;
		}
		
		$latest_entries_query = new WP_Query();
		
		$latest_entries_query_options = array(
			'post_type'      => 'pronamic_photo_entry',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'posts_per_page' => 1,
			'meta_query'     => array( array( 'key' => '_thumbnail_id' ) )
		);
		
		// Get the latest entry of a specific contest
		if ( $contest_ID != $this->latest_entry_ID ) {
			$latest_entries_query = new WP_Query( array_merge_recursive( $latest_entries_query_options, array( 'meta_query' => array( array( 'key' => '_pronamic_photo_contest_id', 'value' => $contest_ID ) ) ) ) );
		}
		
		// Get the latest entry of any contest when the contest ID is set to retrieve the latest entry, or no entries have been found for a specific contest
		if ( $contest_ID == $this->latest_entry_ID ||
			 !$latest_entries_query->have_posts() ) {
			$latest_entries_query = new WP_Query( $latest_entries_query_options );
		}
		
		$data->image = $data->message = '';
		
		if ( $latest_entries_query->have_posts() ) {
			$latest_entry = $latest_entries_query->next_post();
			
			$width = $height = 0;
			
			if ( isset( $instance[ 'width' ] ) &&
				 is_numeric( $instance[ 'width' ] ) ) {
				$width  = $instance[ 'width' ];
			}
			
			if ( isset( $instance[ 'height' ] ) &&
				 is_numeric( $instance[ 'height' ] ) ) {
				$height  = $instance[ 'height' ];
			}
			
			$data->image .= '<a href="' . get_post_permalink( $latest_entry->ID ) . '">';
			
			if ( $width > 0 &&
				 $height > 0) {
			 	$data->image .= get_the_post_thumbnail( $latest_entry->ID, array( $instance[ 'width' ], $instance[ 'height' ] ) );
			}
			else {
				$data->image .= get_the_post_thumbnail( $latest_entry->ID );
			}
			
			$data->image .= '</a>';
		}
		else {
			$data->message .= __( 'No entries have been posted yet.', 'pronamic_photo_contest' );
		}
		
		if ( isset( $instance[ 'content' ] ) ) {
			$data->content = $instance[ 'content' ];
		}
		else {
			$data->content = '';
		}
		
		$data->beforeWidget = $data->afterWidget = $data->beforeTitle = $data->afterTitle = '';
		
		if ( isset( $args[ 'before_widget' ] ) ) {
			$data->beforeWidget = $args[ 'before_widget' ];
		}

		if ( isset( $args[ 'after_widget' ] ) ) {
			$data->afterWidget = $args[ 'after_widget' ];
		}

		if ( isset( $args[ 'before_title' ] ) ) {
			$data->beforeTitle = $args[ 'before_title' ];
		}

		if ( isset( $args[ 'after_title' ] ) ) {
			$data->afterTitle = $args[ 'after_title' ];
		}
		
		include $this->plugin->path . 'admin' . DIRECTORY_SEPARATOR . 'latest_entries_widget.php';
	}
	
	//////////////////////////////////////////////////

	/**
	 * @see WP_Widget::update()
	 */
	public function update( $new_instance, $old_instance ) {
		if ( isset( $new_instance[ 'title' ] ) ) {
			$old_instance[ 'title' ] = $new_instance[ 'title' ];
		}
		
		if ( isset( $new_instance[ 'content' ] ) ) {
			$old_instance[ 'content' ] = $new_instance[ 'content' ];
		}

		if ( isset($new_instance[ 'contest_ID' ] ) &&
			 is_numeric( $new_instance[ 'contest_ID' ] ) ) {
			$old_instance[ 'contest_ID' ] = $new_instance[ 'contest_ID' ];
		}
		
		if ( isset($new_instance[ 'width' ] ) &&
			 is_numeric( $new_instance[ 'width' ] ) ) {
			$old_instance[ 'width' ] = $new_instance[ 'width' ];
		}
		
		if ( isset($new_instance[ 'height' ] ) &&
			 is_numeric( $new_instance[ 'height' ] ) ) {
			$old_instance[ 'height' ] = $new_instance[ 'height' ];
		}

		return $old_instance;
	}
	
	//////////////////////////////////////////////////

	/**
	 * @see WP_Widget::form()
	 */
	public function form( $instance ) {
		$defaults = array(
			'title'      => $this->widget_name,
			'content'    => '',
			'contest_ID' => $this->latest_entry_ID,
			'width'      => 0,
			'height'     => 0
		);

		// Merge database settings with defaults
		$instance = wp_parse_args( (array) $instance, $defaults );

		$latest_entry_ID = $this->latest_entry_ID;
		
		// Get all constests
		$contests_query = new WP_Query( array(
			'post_type'      => 'pronamic_photo_conte',
			'posts_per_page' => -1
		) );
		
		include $this->plugin->path . 'admin' . DIRECTORY_SEPARATOR . 'latest_entries_widget_form.php';
	}
	
	//////////////////////////////////////////////////
	
	/**
	 * Registers this widget, needs to be called on or after the "widgets_init" hook.
	 */
	public static function register_widget() {
		register_widget( __CLASS__ );
	}
}
