<?php if ( $data instanceof stdClass ): ?>

	<?php echo $data->beforeWidget; ?>
	
	<?php if ( strlen( $data->title ) > 0 ): ?>
	
		<?php echo $data->beforeTitle . $data->title . $data->afterTitle; ?>
	
	<?php endif; ?>
	
	<?php if ( strlen( $data->image ) > 0 ): ?>
	
		<div class="photo-contest-latest-entries-image">
			<?php echo $data->image; ?>
		</div>
		
		<?php if ( strlen( $data->content ) > 0 ): ?>
		
			<div class="photo-contest-latest-entries-content">
				<?php echo $data->content; ?>
			</div>
		
		<?php endif; ?>
	
	<?php endif; ?>
	
	<?php echo $data->message; ?>
	
	<?php echo $data->afterWidget; ?>

<?php endif; ?>