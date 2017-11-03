<?php
global $wp_query;
$our_picks = null;
$our_picks_atts = shortcode_atts(array(
    'location' => '',
    'subtitle' => '',
), $atts, $tag);

if( $our_picks_atts['location'] ):

    if( $our_picks_atts['location'] == 'topic-page' ) {
        $category = $wp_query->get_queried_object()->term_id;
    } else {
        $category = '';
    }

    $args = array(
        'post_status' => 'publish',
        'post_type' => 'our_picks',
        'tax_query' => array(
            array(
                'taxonomy' => 'theme_locations',
                'field' => 'slug',
                'terms' => $our_picks_atts['location'],
            ),
        ),
        'numberposts' => 1,
        'cat' => $category,
    );

    $our_pick_post = get_posts($args);
    
    if ( $our_pick_post ) {
        $our_picks = get_field('our-picks', $our_pick_post[0]->ID);
    } 
?>

    <?php if( $our_picks ): ?>

        <div class="sl-our-picks-section-wrapper">

            <h2 class="sl-our-picks-section-title"><?php _e( 'Our Picks', 'streetleverage-tools' ); ?></h2>
            <?php if( !empty( $our_picks_atts['subtitle'] ) ): ?>
                <span class="sl-subtitle"><?php _e( $our_picks_atts['subtitle'], 'streetleverage-tools' ); ?></span>
            <?php endif; ?>

            <div class="row">

                <?php foreach( $our_picks as $our_pick ): ?>

                    <div class="sl-box-post three columns matchheight">
                        <span class="sl-border-hover"></span>
                        <div class="sl-feat-img">
                            <a href="<?php echo get_the_permalink($our_pick['our-pick']); ?>"><?php echo get_the_post_thumbnail($our_pick['our-pick']); ?></a>
                        </div>
                        <div class="sl-box">
                            <div class="sl-like-button"><?php SL_Helper::the_like_button($our_pick['our-pick']); ?></div>
                            <?php if(get_the_terms($our_pick['our-pick'], "category")): ?>
                                <a href="<?php echo get_term_link(get_the_terms($our_pick['our-pick'], "category")[0]); ?>" class="sl-topic-cat"><?php echo get_the_terms($our_pick['our-pick'], "category")[0]->name; ?></a>
                            <?php endif; ?>
                            <h5 class="sl-title"><a href="<?php echo get_the_permalink($our_pick['our-pick']); ?>"><?php echo get_the_title($our_pick['our-pick']); ?></a></h5>
                            <span class="sl-content-type"><?php // echo get_post_type($our_pick['our-pick']); ?></span>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    <?php endif; ?>

<?php endif; ?>
