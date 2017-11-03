<?php

global $post;

$userid = get_field( 'podcast-guest' )['ID'];
include(WP_PLUGIN_DIR . "/streetleverage-tools/templates/sl-user-info-section.php");
