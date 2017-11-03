<?php

?>

<div class="wrap">
    <h1>StreetLeverage Settings</h1>
    <form method="post" action="options.php">
        <?php settings_fields( 'sl-trending-settings' ); ?>
        <?php do_settings_sections( 'sl-trending-settings' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Number of Past Days: </th>
                <td><input type="text" name="sl_trending_days" value="<?php echo esc_attr( get_option( 'sl_trending_days' ) ); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">View Weight: </th>
                <td><input type="text" name="sl_trending_view_weight" value="<?php echo esc_attr( get_option( 'sl_trending_view_weight' ) ); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Like Weight: </th>
                <td><input type="text" name="sl_trending_like_weight" value="<?php echo esc_attr( get_option( 'sl_trending_like_weight' ) ); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Comment Weight: </th>
                <td><input type="text" name="sl_trending_comment_weight" value="<?php echo esc_attr( get_option( 'sl_trending_comment_weight' ) ); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Share Weight: </th>
                <td><input type="text" name="sl_trending_share_weight" value="<?php echo esc_attr( get_option( 'sl_trending_share_weight' ) ); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Text Prompt: </th>
                <td><input type="text" name="sl_trending_text_prompt" value="<?php echo esc_attr( get_option( 'sl_trending_text_prompt' ) ); ?>" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
