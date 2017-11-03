<?php
global $post;
$args = array(
    'post_status' => 'publish',
    'post_type' => 'collections',
    'numberposts' => 4,
);
$recent_collections = get_posts($args);
?>

<?php if( $recent_collections ): ?>

    <div class="sl-more-collections-wrapper">
        <h2 class="sl-section-title"><?php _e( 'Explore Other Collections', 'streetleverage-tools' ); ?></h2>
        <div class="row">
            <?php foreach( $recent_collections as $recent_collection ): ?>
                <div class="sl-box-post three columns matchheight">
                    <span class="sl-border-hover"></span>
                    <div class="sl-feat-img">
                        <a href="<?php echo get_the_permalink( $recent_collection->ID ); ?>"><?php echo get_the_post_thumbnail( $recent_collection ); ?></a>
                    </div>
                    <div class="sl-box">
                        <div class="sl-like-button"><?php SL_Helper::the_like_button($recent_collection->ID); ?></div>
                        <?php if(get_the_terms($recent_collection->ID, "category")): ?>
                            <a href="<?php echo get_term_link(get_the_terms($recent_collection->ID, "category")[0]); ?>" class="sl-topic-cat"><?php echo get_the_terms($recent_collection->ID, "category")[0]->name; ?></a>
                        <?php endif; ?>
                        <h5 class="sl-title"><a href="<?php echo get_the_permalink($recent_collection->ID); ?>"><?php echo get_the_title( $recent_collection->ID ); ?></a></h5>
                        <span class="sl-excerpt"><?php echo SL_Helper::sl_get_the_excerpt( $recent_collection->ID ); ?></span>
                        <a href="<?php echo get_author_posts_url($recent_collection->post_author) ?>">
                            <span class="sl-author">
                                <?php echo __( 'By: ', 'streetleverage-tools' ) . get_userdata($recent_collection->post_author)->display_name; ?>
                            </span>
                        </a>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

