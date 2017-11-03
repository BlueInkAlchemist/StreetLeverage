<?php
$args = array(
    'post_status' => 'publish',
    'post_type' => 'podcasts',
    'numberposts' => 1,
);
$podcasts = get_posts($args);
?>

<div class="sl-recent-scenarios-wrapper">
    <h3 class="sl-recent-scenarios-title"><?php _e('Behind The Practice', 'streetleverage-tools'); ?></h3>
    <?php foreach( $podcasts as $podcast ) : ?>

        <?php if( $podcast ) : ?>


        <div class="sl-box-post">
            <div class="sl-feat-img">
                <a href="<?php echo get_the_permalink( $podcast->ID ); ?>"><?php echo get_the_post_thumbnail( $podcast, 'featimg' ); ?></a>
            </div>
            <div class="sl-box">
                <!-- <div class="sl-like-button"><?php echo do_shortcode('[favorite_button post_id="' . $podcast->ID . '"]'); ?></div>
                <h6 class="sl-title"><a href="<?php echo get_the_permalink( $podcast->ID ); ?>"><?php echo get_the_title( $podcast->ID ); ?></a></h6> -->
                <span class="sl-excerpt"><?php echo get_the_excerpt( $podcast->ID ); ?></span>
                <a class="button orange" href="/behind-the-practice"><?php _e( 'Show Me More', 'streetleverage-tools' ); ?></a>

            </div>
        </div>

        <?php endif; ?>

    <?php endforeach; ?>


</div>