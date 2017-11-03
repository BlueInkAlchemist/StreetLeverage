<?php
global $post;
global $wp_query;

if( is_category() ) {
    $category = $wp_query->get_queried_object();
    $featured_topic = get_field("go-deeper-featured-2", "category_" . $category->term_id)[0];
} else {
    $featured_topic = get_field("go-deeper-featured-2")[0];
}

$args = array(
    'category' => $featured_topic->term_id,
    'post_status' => 'publish',
    'numberposts' => 2,
);
$featured_posts = get_posts($args);

?>

<?php if ($featured_topic) : ?>

    <div class="sl-go-deeper sl-go-deeper-featured-2">

        <h6 class="sl-title"><?php echo $featured_topic->name; ?></h6>
        <div class="sl-go-deeper-posts-wrapper">

            <?php foreach ($featured_posts as $featured_post) : ?>

                <div class="sl-box">
                    <div class="sl-like-button"><?php SL_Helper::the_like_button($featured_post->ID); ?></div>

                   
                    <a href="<?php echo get_term_link(get_the_terms($featured_post->ID, "category")[0]); ?>" class="sl-topic-cat"><?php echo get_the_terms($featured_post->ID, "category")[0]->name; ?></a>
                    <h6 class="sl-title"><a href="<?php echo get_the_permalink($featured_post->ID); ?>"><?php echo get_the_title($featured_post->ID); ?></a></h6>

                </div>

            <?php endforeach; ?>

            <a href="<?php echo get_term_link($featured_topic->term_id); ?>" class="txt-link blue"><?php _e( 'View All', 'streetleverage-tools' ); ?></a>

        </div>

    </div>

<?php endif; ?>
