<?php

function pronamic_photo_contest_get_entries_query_args() {
	return array(
		'post_type'  => 'pronamic_photo_entry',
		'nopaging'   => true,
		'meta_query' => array(
			array(
				'key'     => '_pronamic_photo_contest_id',
				'type'    => 'NUMERIC',
				'value'   => get_the_ID(),
				'compare' => '='
			)
		)
	);
}

function pronamic_photo_contest_get_entries() {
	return get_posts( pronamic_photo_contest_get_entries_query_args() );
}

function pronamic_photo_entry_set_columns( $columns ) {
	$new_columns = array();

	if ( isset( $columns['cb'] ) ) {
		$new_columns['cb'] = $columns['cb'];
	}

	// $newColumns['thumbnail'] = __( 'Thumbnail', 'pronamic_companies' );

	if ( isset( $columns['title'] ) ) {
		$new_columns['title'] = __( 'Title', 'pronamic_photo_contest' );
	}

	$new_columns['pronamic_photo_entry_contest'] = __( 'Photo Contest', 'pronamic_photo_contest' );

	if ( isset( $columns['author'] ) ) {
		$new_columns['author'] = $columns['author'];
	}

	if ( isset( $columns['comments'] ) ) {
		$new_columns['comments'] = $columns['comments'];
	}

	if ( isset( $columns['date'] ) ) {
		$new_columns['date'] = $columns['date'];
	}
	
	return $new_columns;
}

add_filter( 'manage_edit-pronamic_photo_entry_columns' , 'pronamic_photo_entry_set_columns' );

function pronamic_photo_contest_custom_columns( $column, $post_id ) {
	switch ( $column ) {
		case 'pronamic_photo_entry_contest':
			$contest_id = get_post_meta( $post_id, '_pronamic_photo_contest_id', true );

			if ( empty( $contest_id ) ) {
				_e( 'No contest', 'pronamic_photo_contest' );
			} else {
				printf(
					'<a href="%s">%s</a>',
					get_edit_post_link( $contest_id ),
					get_the_title( $contest_id )
				);
				
				echo '<div class="row-actions">';

				edit_post_link();

				echo ' | ';

				printf(
					'<a href="%s">%s</a>',
					get_permalink( $contest_id ),
					__( 'View', 'pronamic_photo_contest' )
				);

				echo '</div>';
			}
			
			break;
	}
}

add_action( 'manage_posts_custom_column' , 'pronamic_photo_contest_custom_columns', 10, 2 );

/**
 * The content
 * 
 * @param unknown $content
 * @return string
 */
function pronamic_photo_contest_the_content( $content ) {
	if ( is_singular( 'pronamic_photo_conte' ) ) {
		$entries = pronamic_photo_contest_get_entries();
		
		$extra = '';

		if ( empty( $entries ) ) {
			
		} else {
			wp_enqueue_style( 'pronamic-photo-contest' );

			$extra .= '<div class="pronamic-photo-entries">';
			$extra .= '<ul class="pronamic-photo-entries-list">';
			
			foreach ( $entries as $entry ) {
				$extra .= '<li>';

				$extra .= sprintf( '<a href="%s">', get_permalink( $entry->ID ) );
				
				$extra .= get_the_post_thumbnail( $entry->ID, 'thumbnail' );
				
				$extra .= sprintf( '</a>' );

				$extra .= '</li>';
			}

			$extra .= '</ul>';
			$extra .= '<div class="pronamic-photo-entries-clear"></div>';
			$extra .= '</div>';
			
		}
		
		$content .= $extra;
	}

	return $content;
}

// add_filter( 'the_content', 'pronamic_photo_contest_the_content' );
