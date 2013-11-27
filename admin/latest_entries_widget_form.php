<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' , 'pronamic_photo_contest' ); ?>:</label>
	
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo htmlspecialchars( $instance[ 'title' ] ); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e( 'Content' , 'pronamic_photo_contest' ); ?>:</label>
	
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" value="<?php echo htmlspecialchars( $instance[ 'content' ] ); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'contest_ID' ); ?>"><?php _e( 'Contest' , 'pronamic_photo_contest' ); ?>:</label>
	
	<select class="widefat" id="<?php echo $this->get_field_id( 'contest_ID' ); ?>" name="<?php echo $this->get_field_name( 'contest_ID' ); ?>" style="width:100%">
		
		<option value="<?php echo htmlspecialchars( $latest_entry_ID ); ?>" <?php selected( $instance[ 'contest_ID' ], $latest_entry_ID ); ?>><?php _e( 'Latest entry', 'pronamic_photo_contest' ); ?></option>
		
		<?php while( $contests_query->have_posts() ): $contest = $contests_query->next_post(); ?>
			<option value="<?php echo $contest->ID; ?>" <?php selected( $instance[ 'contest_ID' ], $contest ->ID ); ?>><?php echo !empty($contest->post_title) ? $contest->post_title : __( 'Untitled contest', 'pronamic_photo_contest' ); ?></option>
		<?php endwhile; ?>
		
	</select>
</p>

<p>
	<h4><?php _e( 'Image size', 'pronamic_photo_contest' ); ?></h4>

	<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width' , 'pronamic_photo_contest' ); ?>:</label>
	
	<input type="text" size="4" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo htmlspecialchars( $instance[ 'width' ] ); ?>" /><br />
	
	<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height' , 'pronamic_photo_contest' ); ?>:</label>
	
	<input type="text" size="4" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo htmlspecialchars( $instance[ 'height' ] ); ?>" />
</p>