<?php
$args = array(
    'post_status' => 'publish',
    'post_type' => 'scenarios',
    'numberposts' => 4,
);
$scenarios = get_posts($args);
?>

<div class="sl-recent-scenarios-wrapper">
    <h3 class="sl-section-title"><?php _e('Reflection Room', 'streetleverage-tools'); ?></h3>
    <?php foreach( $scenarios as $scenario ) : ?>

        <?php if( $scenario ) : ?>

            <div class="sl-box matchheight">
                 <div class="sl-like-button"><?php SL_Helper::the_like_button($scenario->ID); ?></div>
                <h6 class="sl-title"><a href="<?php echo get_the_permalink( $scenario->ID ); ?>"><?php echo get_the_title( $scenario->ID ); ?></a></h6>

            </div>

        <?php endif; ?>

    <?php endforeach; ?>


</div>