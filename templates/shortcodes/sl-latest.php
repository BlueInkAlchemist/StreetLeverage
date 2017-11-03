<?php

global $wp_query;

$latest_helper = SL_Helper::get_instance();

$latest_atts = shortcode_atts(array(
    'location' => 'homepage',
    'category' => '',
    'type' => '',
), $atts, $tag);

if ($latest_atts['location'] == 'member' ) {
    $user_id = get_current_user_id();
    $gf_content_array = get_user_meta($user_id, 'gf_content');
    $gf_content_xploded = array_map('intval', explode(", ", $gf_content_array[0]));
    $args = array(
        'category' => $gf_content_xploded,
        'numberposts' => 3,
        'post_status' => 'publish'
    );
} else {
    $args = array(
        'numberposts' => 3,
        'post_status' => 'publish'
    );
}

$recent_posts = wp_get_recent_posts($args);


?>

<div class="sl-latest-section">

    <h2 class="sl-section-title"><?php _e("Latest"); ?></h2>

    <?php foreach($recent_posts as $recent): ?>

        <?php 
           $latest_title = SL_Helper::max_title_length(get_the_title( $recent["ID"] )); 
        ?>

        <div class="sl-box">
            <div class="sl-like-button"><?php SL_Helper::the_like_button($recent["ID"]); ?></div>
            <?php if(get_the_terms( $recent["ID"], "category")) : ?>
                <a href="<?php echo get_term_link( get_the_terms( $recent["ID"], "category")[0] ); ?>" class="sl-topic-cat"><?php echo get_the_terms( $recent["ID"], "category" )[0]->name; ?></a>
            <?php endif; ?>
            <h6 class="sl-title"> <a href="<?php echo get_the_permalink($recent["ID"]); ?>"><?php echo $latest_title; ?></a></h6>
        </div>

    <?php endforeach; ?>

    <div class="text-center"><a href="/archives/">More Recent Posts</a></div>

</div>


