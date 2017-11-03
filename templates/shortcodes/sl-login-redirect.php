<?php 
global $sl_helper;

add_filter( 'gform_user_registration_login_args', array($sl_helper, 'sl_shortcode_login_redirect_url'), 10, 1 );

?>