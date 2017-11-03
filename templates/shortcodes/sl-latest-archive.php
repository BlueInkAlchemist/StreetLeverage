<?php
global $wp_query;

$category = null;

$latest_atts = shortcode_atts(array(
    'title' => 'Latest',
    'subtitle' => '',
    'numposts' => 12,
    'type' => '',
    'location' => '',
    'viewall' => 1
), $atts, $tag);

if( $latest_atts['location'] == 'topic-page' ) {
    $category = $wp_query->get_queried_object()->term_id;
    $name = $wp_query->get_queried_object()->name;
}

$args = array(
    'numberposts' => $latest_atts['numposts'],
    'post_type' => $latest_atts['type'],
    'cat' => $category,
    'post_status' => 'publish',
);
if ( !$latest_atts['type'] ){
    $args['post_type'] = array( 'post', 'events', 'podcasts', 'scenarios', 'live_presentations');
} else if( $latest_atts['type'] == "events" ) {
    $today = date('Ymd');
    $args['meta_key'] = 'start-date';
    $args['orderby'] = 'meta_value';
    $args['order'] = 'ASC';
    $args['meta_query'] = array(
        array(
            'key' => 'start-date',
            'value' => $today,
            'compare' => '>='
        )
    );
}
$this_id = get_the_ID();
if ( $this_id == 14830 ) {
   // $args['post_type'] = 'live_presentations';
}


$latest_posts = get_posts($args);

$i = 0;

?>

<div class="sl-latest-archive-section">

    <?php
        if( $latest_atts['location'] == 'topic-page' ) {
            $this_title = 'Latest in ' . $name;
        } else {
            $this_title = $latest_atts['title'];
        }
    ?>

    <h2 class="sl-section-title"><?php _e( $this_title, 'streetleverage-tools' ); ?></h2>
    <?php if( !empty( $latest_atts['subtitle'] ) ): ?>
        <span class="sl-subtitle"><?php _e( $latest_atts['subtitle'], 'streetleverage-tools' ); ?></span>
    <?php endif; ?>

    <div class="sl-latest-posts">

        <div class="row">

            <?php if ( empty( $latest_posts ) && $latest_atts['type'] == 'events' ) : ?>
            <div class="no-events">No events scheduled at this time.</div>
            <?php endif; ?>


            <?php foreach($latest_posts as $latest_post): ?>
                <?php if( $latest_post->ID != get_the_ID() ) : ?>
                    <div class="sl-latest-archive-post-wrapper three columns matchheight sl-box-post">
                        <span class="sl-border-hover"></span>
                        <div class="sl-feat-img">
                            <a href="<?php echo get_the_permalink( $latest_post->ID ); ?>"><?php echo get_the_post_thumbnail( $latest_post->ID, 'featimg' ); ?></a>
                        </div>
                        <div class="sl-box">
                            <div class="sl-like-button"><?php SL_Helper::the_like_button($latest_post->ID); ?></div>
                            <?php if( get_the_terms( $latest_post->ID, "category" ) ) : ?>
                                <a href="<?php echo get_term_link( get_the_terms( $latest_post->ID, "category")[0] ); ?>" class="sl-topic-cat"><?php echo get_the_terms( $latest_post->ID, "category" )[0]->name; ?></a>
                            <?php endif; ?>
                            <h4 class="sl-title"><a href="<?php echo get_the_permalink( $latest_post->ID ); ?>"><?php echo get_the_title( $latest_post->ID ); ?></a></h4>
                            <a href="<?php echo get_author_posts_url($latest_post->post_author) ?>">
                                <span class="sl-author">
                                    <?php echo __( 'By: ', 'streetleverage-tools' ) . get_userdata($latest_post->post_author)->display_name; ?>
                                </span>
                            </a>
                        </div>
                    </div>

                    <?php $i++ ?>
                    <?php if( $i % 4 == 0 ): ?>
                        </div><div class="row">
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>

        </div>

        <?php if( $latest_atts['viewall'] == 1 ): ?>

            <?php if ( empty( $latest_posts ) && $latest_atts['type'] == 'events' ) : ?>
                <!-- nothing -->
            <?php elseif( $latest_atts['location'] == 'topic-page' ): ?>
                <a href="<?php echo get_site_url() . "/archives/?topic=" . $category ?>" class="orange button"><?php _e( 'View All', 'streetleverage-tools' ); ?></a>
            <?php elseif( $latest_atts['type'] ): ?>
                <a href="<?php echo get_site_url() . "/archives/?type=" . $latest_atts['type'] ?>" class="orange button"><?php _e( 'View All', 'streetleverage-tools' ); ?></a>
            <?php endif; ?>

        <?php endif; ?>

    </div>

</div>


