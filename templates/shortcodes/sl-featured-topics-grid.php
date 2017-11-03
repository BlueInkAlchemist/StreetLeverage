<?php

$featured_topics_atts = shortcode_atts(array(
    'location' => 'homepage',
    'category' => '',
), $atts, $tag);

$is_specified = true;

if( $featured_topics_atts['location'] ):

    if( $featured_topics_atts['location'] == 'topic-page' ) {
        $category = get_queried_object()->term_id;
    } else {
        $category = '';
    }
    $args = array(
        'post_status' => 'publish',
        'post_type' => 'featured_topics',
        'tax_query' => array(
            array(
                'taxonomy' => 'theme_locations',
                'field' => 'slug',
                'terms' => $featured_topics_atts['location'],
            ),
        ),
        'numberposts' => 1,
        'cat' => $category,
    );
    $featured_topic_post = get_posts($args);
    if (!$featured_topic_post) {
        $is_specified = false;
        $cats = get_categories( array(
            'orderby' => 'name',
            'parent'  => 0,
            'hide_empty' => false
        ) );
        $cat_litter = array();
        foreach ($cats as $cat) : 
            $descendant= get_term_children( $cat->term_id, $cat->taxonomy );
            if ( !empty($descendant)) :
                array_push($cat_litter, $cat);
            endif;
        endforeach;
        $featured_topics = $cat_litter;        
    } else {
        $featured_topics = get_field('featured-topics', $featured_topic_post->ID);
    }
    $fl = count($featured_topics);
    $i = 0;
?>

    <?php if( $featured_topics ): ?>

        <div class="sl-featured-topics-section-wrapper">

            <h3 class="sl-section-title"><?php _e( 'Find additional goodness in these topic areas.', 'streetleverage-tools' ); ?></h3>
			<div class="row">
            <?php foreach( $featured_topics as $featured_topic ): ?>
                <?php if( $is_specified ) : ?>
                    <?php $featured_topic = $featured_topic['featured-topic']; ?>
                <?php endif; ?>
                <?php $topic_title = $featured_topic->name; ?>
                <?php $topic_thumb_url = get_field( 'topic_thumbnail', $featured_topic )["sizes"]["medium"]; ?>
                <?php if( is_string( get_term_link( $featured_topic, "category" ) ) ) : ?>
                    <div onclick="location.href='<?php echo get_term_link( $featured_topic, "category" ); ?>'" class="sl-square three columns matchheight" style="cursor: pointer;background:rgba(0,0,0,0) url(<?php echo $topic_thumb_url ?>) no-repeat scroll center top / cover;">
                        <span class="sl-border-hover"></span>
                        <div class="sl-wrapper">
                            <h5 class="sl-title"><?php echo $topic_title; ?></h5>
                        </div>
                        <div class="color-filter"></div>

                    </div>
                <?php else : ?>    
                    <?php break 1; ?>
                <?php endif; ?>
                <?php $fl--; ?>
                <?php $i++; ?>
                
                <?php if($i%4 == 0): ?>
                    </div>
                    <?php if($fl < 4):?>
                    </div>
                    <?php break; 
                    endif; ?>
                    <div class="row">
                <?php endif; ?>

            <?php endforeach; ?>
                    </div>
        </div>

    <?php endif; ?>

<?php endif; ?>
