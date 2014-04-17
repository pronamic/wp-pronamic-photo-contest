<?php

global $post;

wp_nonce_field( 'pronamic_photo_entry_save', 'pronamic_photo_entry_meta_box_nonce' );

$fields = array(
	array(
		'label'    => __( 'Contest', 'pronamic_photo_contest' ),
		'meta_key' => '_pronamic_photo_contest_id',
		'type'     => 'dropdown_photo_contests'
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
				<?php 
				
				$value = get_post_meta( $post->ID, $field['meta_key'], true );
				
				if ( $field['type'] == 'dropdown_photo_contests' ) {
					
					$contests = get_posts( array( 'post_type' => 'pronamic_photo_conte', 'nopaging' => true ) );

					printf(
						'<select id="%s" name="%s">',
						$field['meta_key'],
						$field['meta_key']
					);

					printf(
						'<option value="%s" %s>%s</option>',
						'',
						selected( '', $value, false ),
						''
					);

					foreach ( $contests as $contest ) {
						printf(
							'<option value="%s" %s>%s</option>',
							$contest->ID,
							selected( $contest->ID, $value, false ),
							$contest->post_title
						);
					}
					
					printf( '</select>' );
					
				} else {

					printf(
						'<input id="%s" name="%s" value="%s" type="%s" class="regular-text" />',
						$field['meta_key'],
						$field['meta_key'],
						$value,
						$field['type']
					);

				}
				
				?>
				
			</td>
		</tr>

	<?php endforeach; ?>

</table>