<?php

global $post;

$entries = pronamic_photo_contest_get_entries();

wp_enqueue_style( 'pronamic-photo-contest' );

?>
<div class="pronamic-photo-entries">

	<?php if ( empty( $entries ) ) : ?>
	
		<p>
			<?php _e( 'No entries.', 'pronamic_photo_contest' ); ?>
		</p>
	
	<?php else : ?>

		<ul class="pronamic-photo-entries-list">

			<?php foreach ( $entries as $entry ) : ?>

				<li>					
					<?php 
					
					printf(
						'<a href="%s" target="_blank">%s</a>',
						get_permalink( $entry->ID ),
						get_the_post_thumbnail( $entry->ID, 'medium' )
					);
					
					echo '<br />';

					printf(
						'<a href="%s" target="_blank">%s</a>',
						get_permalink( $entry->ID ),
						__( 'View', 'pronamic_photo_contest' )
					);
					
					echo ' | ';
					
					printf(
						'<a href="%s" target="_blank">%s</a>',
						get_edit_post_link( $entry->ID ),
						__( 'Edit', 'pronamic_photo_contest' )
					);
					
					?>
				</li>

			<?php endforeach; ?>
		</ul>
		
		<div class="pronamic-photo-entries-clear"></div>
	
	<?php endif; ?>

</div>