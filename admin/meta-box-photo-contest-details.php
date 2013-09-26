<?php

global $post;

wp_nonce_field( 'pronamic_photo_contest_save', 'pronamic_photo_contest_meta_box_nonce' );

$fields = array(
	array(
		'label'    => __( 'Start Date Submit', 'pronamic_photo_contest' ),
		'meta_key' => '_pronamic_photo_contest_submit_start_date',
		'type'     => 'text'
	),
	array(
		'label'    => __( 'End Date Submit', 'pronamic_photo_contest' ),
		'meta_key' => '_pronamic_photo_contest_submit_end_date',
		'type'     => 'text'
	),
	array(
		'label'    => __( 'Start Date Vote', 'pronamic_photo_contest' ),
		'meta_key' => '_pronamic_photo_contest_vote_start_date',
		'type'     => 'text'
	),
	array(
		'label'    => __( 'End Date Vote', 'pronamic_photo_contest' ),
		'meta_key' => '_pronamic_photo_contest_vote_end_date',
		'type'     => 'text'
	)
);

?>
<table class="form-table">

	<?php foreach ( $fields as $field ) : ?>
	
		<tr valign="top">
			<th scope="row">
				<label for="<?php echo $field['meta_key']; ?>"><?php echo $field['label']; ?></label>
			</th>
			<td>
				<input id="<?php echo $field['meta_key']; ?>" name="<?php echo $field['meta_key']; ?>" value="<?php echo get_post_meta( $post->ID, $field['meta_key'], true ); ?>" type="<?php echo $field['type']; ?>" class="regular-text" />
			</td>
		</tr>

	<?php endforeach; ?>

</table>