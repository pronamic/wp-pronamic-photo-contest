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

add_filter( 'the_content', 'pronamic_photo_contest_the_content' );
