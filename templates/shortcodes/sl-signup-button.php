<?php
switch_to_blog( 1 );
?>

<?php if(is_user_logged_in()): ?>
	<div style="text-align: right;">
		<a href="<?php echo get_site_url() . "/member-home" ?>" style="text-align: center;" class="sl-member-btn"><?php _e( 'My Account', 'streetleverage-tools' ); ?></a>
	</div>
<?php else: ?>
	<div style="text-align: right;">
    	<a href="<?php echo get_site_url() . "/sign-up" ?>" style="text-align: center;" class="sl-member-btn"><?php _e( 'Sign Up', 'streetleverage-tools' ); ?></a>
	</div>
<?php endif; ?>
<?php restore_current_blog(); ?>