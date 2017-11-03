<?php
global $current_user;
wp_get_current_user();
if (!is_user_logged_in()) {
    $login_url = site_url( '/login/' );
    wp_redirect( $login_url );
    exit;
}
$favorites = array_reverse(get_user_favorites());
$i = 0;
?>

<?php if( !is_array( $favorites[0] ) ): ?>

    <div class="sl-member-likes-wrapper">
        <h2 class="sl_title">Saved Content</h2><br/>
        <div class="row">
            <?php $i=0; ?>
            <?php foreach( $favorites as $favorite ): ?>

                <div class="sl-likes-post-wrapper three columns matchheight sl-box-post">
                    <span class="sl-border-hover"></span>
                    <div class="sl-feat-img">
                        <a href="<?php echo get_the_permalink( $favorite ); ?>"><?php echo get_the_post_thumbnail( $favorite, 'featimg' ); ?></a>
                    </div>
                    <div class="sl-box">
                        <div class="sl-like-button"><?php SL_Helper::the_like_button($favorite); ?></div>
                        <?php if( SL_Helper::get_primary_topic($favorite) ) : ?>
                            <a href="<?php echo get_term_link( SL_Helper::get_primary_topic($favorite) ); ?>" class="sl-topic-cat"><?php echo SL_Helper::get_primary_topic($favorite)->name; ?></a>
                        <?php endif; ?>
                        <h4 class="sl-title"><a href="<?php echo get_the_permalink( $favorite ); ?>"><?php echo get_the_title( $favorite ); ?></a></h4>
                        <a href="<?php echo get_author_posts_url(get_post($favorite)->post_author) ?>">
                            <span class="sl-author"><?php echo __( 'By: ', 'streetleverage-tools' ) . get_userdata(get_post($favorite)->post_author)->display_name; ?></span>
                        </a>
                    </div>
                </div>
                
                <?php if($i==3) break; ?>
                <?php $i++ ?>
            <?php endforeach; ?>
            <br/>
        </div>
        <div class="row text-center">
	        <a href="/likes-saves/" class="orange button"><?php _e( 'View All', 'streetleverage-tools' ); ?></a>
        </div>
    </div>

<?php else : ?>

    <div class="sl-member-likes-wrapper">
        <h2 class="sl_title">Recently Saved Content</h2><br/>
        <div class="row">
            <h4>Click on the star on any content to save it here to your library.</h4>
        </div>
    </div>

<?php endif; ?>
