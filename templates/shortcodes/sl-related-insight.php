<?php
global $wp_query;

$latest_atts = shortcode_atts(array(
    'title' => 'Related Insight',
    'subtitle' => '',
    'numposts' => 12,
    'type' => '',
    'location' => '',
    'viewall' => 1
), $atts, $tag);

if( $latest_atts['location'] == 'topic-page' ) {
    $category = $wp_query->get_queried_object()->term_id;
}

$args = array(
    'numberposts' => $latest_atts['numposts'],
    'post_type' => $latest_atts['type'],
    'post_status' => 'publish',
);

if( $latest_atts['location'] == 'topic-page' ) {
    $category = $wp_query->get_queried_object()->term_id;
    $args['cat'] = $category;
}

if( isset($latest_atts['post_type'])) {
    if ($latest_atts['post_type'] == "events") {
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
}

$latest_posts = get_posts($args);
// echo var_dump( $latest_posts );
$related_insights = get_field("sl_related_insights", get_the_ID() );
// echo var_dump( $related_insights );
?>
<?php if($related_insights): ?>
    <div class="sl-related-insights-wrapper">
        <h3 class="sl-section-title"><?php _e( $latest_atts['title'], 'streetleverage-tools' ); ?></h3>
        <?php foreach($related_insights as $related_insight) :
            if ($related_insight): ?>
                <div class="sl-box">
                    <div class="sl-like-button"><?php SL_Helper::the_like_button($related_insight["insight"]); ?></div>
                    <?php if(get_the_terms( $related_insight["insight"], "category")) : ?>
                            <a href="<?php echo get_term_link( get_the_terms( $related_insight["insight"], "category")[0] ); ?>" class="sl-topic-cat"><?php echo get_the_terms( $related_insight["insight"], "category" )[0]->name; ?></a>
                        <?php endif; ?>
                   <h6 class="sl-title"> <a href="<?php echo get_the_permalink($related_insight["insight"]); ?>"><?php echo get_the_title($related_insight["insight"]); ?></a></h6>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>