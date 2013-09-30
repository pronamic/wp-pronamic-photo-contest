<?php

function pronamic_photo_contest_between_date( $post_id, $meta_key_start, $meta_key_end ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;

	$start_value = get_post_meta( $post_id, $meta_key_start, true );
	$end_value   = get_post_meta( $post_id, $meta_key_end, true );
	
	$start = strtotime( $start_value );
	$end   = strtotime( $end_value );

	$now   = time();

	$start = empty( $start ) ? $now : $start;
	$end   = empty( $end ) ? $now : $end;
	
	return ( $now >= $start && $now <= $end );
}

function pronamic_photo_contest_period( $post_id, $meta_key_start, $meta_key_end ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;

	$start_value = get_post_meta( $post_id, $meta_key_start, true );
	$end_value   = get_post_meta( $post_id, $meta_key_end, true );
	
	if ( ! empty( $start_value ) && ! empty( $end_value ) ) {
		printf(
			__( '%s to %s', 'pronamic_photo_contest' ),
			$start_value,
			$end_value
		);
	}
}

function pronamic_photo_contest_submit_period( $post_id = null ) {
	return pronamic_photo_contest_period( $post_id, '_pronamic_photo_contest_submit_start_date', '_pronamic_photo_contest_submit_end_date' );
}

function pronamic_photo_contest_can_submit( $post_id = null ) {
	return pronamic_photo_contest_between_date( $post_id, '_pronamic_photo_contest_submit_start_date', '_pronamic_photo_contest_submit_end_date' );
}

function pronamic_photo_contest_vote_period( $post_id = null ) {
	return pronamic_photo_contest_period( $post_id, '_pronamic_photo_contest_vote_start_date', '_pronamic_photo_contest_vote_end_date' );
}

function pronamic_photo_contest_can_vote( $post_id = null ) {
	return pronamic_photo_contest_between_date( $post_id, '_pronamic_photo_contest_vote_start_date', '_pronamic_photo_contest_vote_end_date' );
}
