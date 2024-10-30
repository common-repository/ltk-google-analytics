<div class="wrap">
	<h1><?php _e( 'Google Analytics', 'ltk-google-analytics' ); ?></h1>
	<form action="options.php" method="post" novalidate>
		<?php settings_fields('ltk-google-analytics'); ?>
		<?php do_settings_sections('ltk-google-analytics'); ?>
		<?php submit_button(); ?>
	</form>
</div>
