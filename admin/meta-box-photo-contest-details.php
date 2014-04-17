<?php

global $post;

wp_nonce_field( 'pronamic_photo_contest_save', 'pronamic_photo_contest_meta_box_nonce' );


?>
<table class="form-table">
	<tr valign="top">
		<th scope="row">
			<label for="_pronamic_photo_contest_submit_start_date"><?php _e( 'Submit Period', 'pronamic_photo_contest' ); ?></label>
		</th>
		<td>
			<?php 

			printf(
				__( '%s to %s', 'pronamic_photo_contest' ),
				sprintf(
					'<input id="%s" name="%s" value="%s" type="%s" class="%s" />',
					esc_attr( '_pronamic_photo_contest_submit_start_date' ),
					esc_attr( '_pronamic_photo_contest_submit_start_date' ),
					esc_attr( get_post_meta( $post->ID, '_pronamic_photo_contest_submit_start_date', true ) ),
					esc_attr( 'text' ),
					esc_attr( 'date' )
				),
				sprintf(
					'<input id="%s" name="%s" value="%s" type="%s" class="%s" />',
					esc_attr( '_pronamic_photo_contest_submit_end_date' ),
					esc_attr( '_pronamic_photo_contest_submit_end_date' ),
					esc_attr( get_post_meta( $post->ID, '_pronamic_photo_contest_submit_end_date', true ) ),
					esc_attr( 'text' ),
					esc_attr( 'date' )
				)
			);
			
			$description = sprintf( 
				__( 'This contest is currently %s for new entries.', 'pronamic_photo_contest' ),
				sprintf(
					'<strong>%s</strong>',
					pronamic_photo_contest_can_submit( $post->ID ) ? __( 'open', 'pronamic_photo_contest' ) : __( 'closed', 'pronamic_photo_contest' )
				)
			);

			?>
			<span class="description"><br /><?php echo $description; ?></span>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">
			<label for="_pronamic_photo_contest_vote_start_date"><?php _e( 'Vote Period', 'pronamic_photo_contest' ); ?></label>
		</th>
		<td>
			<?php 

			printf(
				__( '%s to %s', 'pronamic_photo_contest' ),
				sprintf(
					'<input id="%s" name="%s" value="%s" type="%s" class="%s" />',
					esc_attr( '_pronamic_photo_contest_vote_start_date' ),
					esc_attr( '_pronamic_photo_contest_vote_start_date' ),
					esc_attr( get_post_meta( $post->ID, '_pronamic_photo_contest_vote_start_date', true ) ),
					esc_attr( 'text' ),
					esc_attr( 'date' )
				),
				sprintf(
					'<input id="%s" name="%s" value="%s" type="%s" class="%s" />',
					esc_attr( '_pronamic_photo_contest_vote_end_date' ),
					esc_attr( '_pronamic_photo_contest_vote_end_date' ),
					esc_attr( get_post_meta( $post->ID, '_pronamic_photo_contest_vote_end_date', true ) ),
					esc_attr( 'text' ),
					esc_attr( 'date' )
				)
			);
			
			$description = sprintf( 
				__( 'This contest is currently %s for votes.', 'pronamic_photo_contest' ),
				sprintf(
					'<strong>%s</strong>',
					pronamic_photo_contest_can_vote( $post->ID ) ? __( 'open', 'pronamic_photo_contest' ) : __( 'closed', 'pronamic_photo_contest' )
				)
			);
			
			?>
			<span class="description"><br /><?php echo $description; ?></span>
		</td>
	</tr>
</table>

<script type="text/javascript">
	jQuery( document ).ready( function( $ ) {
		var fields = $( 'input.date' );

		fields.datepicker( {
			dateFormat: 'dd-mm-yy'
		} );
	} );
</script>