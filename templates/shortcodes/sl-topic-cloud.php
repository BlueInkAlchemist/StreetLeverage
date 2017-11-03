<?php
$trending_helper = SL_Trending_Helper::get_instance();
$trending_posts = $trending_helper->getTrendingPosts(50);
$trending_topics = array();

foreach ( $trending_posts as $trending_post ) {
    if (get_the_terms( $trending_post->ID, "category")) {
        if ( !in_array( get_the_terms( $trending_post->ID, "category" )[0], $trending_topics ) ) {
            $trending_topics[] = get_the_terms( $trending_post->ID, "category" )[0];
        }
        if( count($trending_topics) >= 15 ) {
            break;
        }
    }
}
?>

<div class="sl-topic-cloud-wrapper">
    <h3 class="sl-section-title"><?php _e( "What's everyone chatting about?", 'streetleverage-tools' ); ?></h3>

    <?php foreach ( $trending_topics as $trending_topic ) : ?>
        
        <div class="sl-trending-topic">
            <a href="<?php echo get_term_link( $trending_topic ); ?>" class="button white"><?php echo $trending_topic->name; ?></a>
        </div>

    <?php endforeach; ?>

</div>