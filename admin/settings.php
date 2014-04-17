<div class="wrap">
	<?php screen_icon(); ?>

	<h2><?php echo get_admin_page_title(); ?></h2>

	<form name="form" action="options.php" method="post">
		<?php settings_fields( 'pronamic_photo_contest' ); ?>

		<?php do_settings_sections( 'pronamic_photo_contest' ); ?>

		<?php submit_button(); ?>
	</form>
</div>