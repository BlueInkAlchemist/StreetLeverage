<?php
global $current_user;
wp_get_current_user();
if (!is_user_logged_in()) {
    $login_url = site_url( '/login/' );
    wp_redirect( $login_url );
    exit;
}
?>
<div class="sl-post-title">
    <div class="sl-member-settings"><a href="/user-update/"><?php _e('Account Settings', 'streetleverage-tools'); ?></a></div>
    <div class="sl-member-settings"><a href="/topic-preferences/"><?php _e('Topic Preferences', 'streetleverage-tools'); ?></a></div>
    <br/><h1 class="sl-title"><?php echo $current_user->user_firstname . " " . $current_user->user_lastname; ?></h1>
    <div class="sl-member-blurb">This is your content home at StreetLeverage. We’ll serve stuff up according to your preference and give you a place to save it for later.</div>
</div>
