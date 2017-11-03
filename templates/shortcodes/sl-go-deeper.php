<?php
global $post;
global $wp_query;

$display_section = true;

if( is_category() ) {
    $category = $wp_query->get_queried_object();
    if( !get_term_children( $category->term_id, 'category' ) ) {
        $is_child = true;
    } else {
        $is_child = false;
    }
}

// echo var_dump($category);

if( $display_section ):
    if( is_category() ) {
        $featured_topic_1 = get_field("go-deeper-featured-1");
        $featured_topic_2 = get_field("go-deeper-featured-2");
        if($is_child) {
            $parent_topic_id = $category->parent;
        } else {
            $parent_topic_id = $category->term_id;
        }
        $more_resources = get_field( 'more-resources', 'category_' . $category->term_id );

        if( $featured_topic_1->term_id != $category->term_id ) {
            $fp1_args = array(
                'cat' => $featured_topic_1->term_id,
                'post_status' => 'publish'
            );
            $featured_posts_1 = get_posts($fp1_args);
        } 

        if( $featured_topic_1->term_id != $category->term_id ) {
            $fp2_args = array(
                'cat' => $featured_topic_2->term_id,
                'post_status' => 'publish'
            );
            $featured_posts_2 = get_posts($fp2_args);
        }

        $cat_exclude = $category;

    } else {
        $featured_topic_1 = get_field("go-deeper-featured-1");
        $featured_topic_2 = get_field("go-deeper-featured-2");
        $parent_topic_id = get_the_terms($post->ID, 'category')->parent;
        $more_resources = get_field('more-resources');

        $fp1_args = array(
            'cat' => $featured_topic_1->term_id,
            'post_status' => 'publish',
        );
        $featured_posts_1 = get_posts($fp1_args);

        $fp2_args = array(
            'cat' => $featured_topic_2->term_id,
            'post_status' => 'publish'
        );
        $featured_posts_2 = get_posts($fp2_args);

        $cat_exclude = get_the_terms($post->ID, 'category')[0];
    }

    $featured_topics = array($featured_topic_1->term_id, $featured_topic_2->term_id);
    if( $parent_topic_id ) {
        $subtopics = get_term_children( $parent_topic_id, 'category' );
    } else {
        $subtopics = get_term_children(get_the_terms($post->ID, 'category')[0]->parent, 'category');
    }

    ?>

    <div class="sl-go-deeper-section-wrapper">
    <?php if( $featured_topic_1 ): ?>
        <h2 class="sl-section-title"><?php _e( 'Go Deeper', 'streetleverage-tools' ); ?></h2>
        
        <div class="row">
            <?php if( $featured_topic_1 ): ?>
                <div class="sl-go-deeper-featured-1 four columns">
                    <h6 class="sl-title"><?php echo $featured_topic_1->name; ?></h6>
                    <div class="sl-go-deeper-posts-wrapper">
                        <?php $i = 0; ?>
                        <?php foreach ($featured_posts_1 as $featured_post) : ?>
                            <?php if( (SL_Helper::get_primary_topic($featured_post->ID) != SL_Helper::get_primary_topic($post->ID, 'category') ) && ( $i < 2 ) ) : ?>
                                <div class="sl-box">
                                    <div class="sl-like-button"><?php SL_Helper::the_like_button($featured_post->ID); ?></div>
                                    <?php if( SL_Helper::get_primary_topic($featured_post->ID) ): ?>
                                        <a href="<?php echo get_term_link(SL_Helper::get_primary_topic($featured_post->ID)); ?>" class="sl-topic-cat"><?php echo SL_Helper::get_primary_topic($featured_post->ID)->name; ?></a>
                                    <?php endif; ?>
                                    <h6 class="sl-title"><a href="<?php echo get_the_permalink($featured_post->ID); ?>"><?php echo get_the_title($featured_post->ID); ?></a></h6>
                                </div>
                                <?php $i++; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php if( $featured_topic_1->term_id ): ?>
                            <a href="<?php echo get_term_link($featured_topic_1->term_id); ?>" class="txt-link blue"><?php _e( 'View All', 'streetleverage-tools' ); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if( $featured_topic_2 ): ?>
                <div class="sl-go-deeper-featured-2 four columns">
                    <h6 class="sl-title"><?php echo $featured_topic_2->name; ?></h6>
                    <div class="sl-go-deeper-posts-wrapper">
                        <?php $i = 0; ?>
                        <?php foreach ($featured_posts_2 as $featured_post) : ?>
                                <?php if( (SL_Helper::get_primary_topic($featured_post->ID) != SL_Helper::get_primary_topic($post->ID, 'category') ) && ( $i < 2 ) ) : ?>
                                <div class="sl-box">
                                    <div class="sl-like-button"><?php SL_Helper::the_like_button($featured_post->ID); ?></div>
                                    <?php if( get_the_terms($featured_post->ID, "category") ): ?>
                                        <a href="<?php echo get_term_link(get_the_terms($featured_post->ID, "category")[0]); ?>" class="sl-topic-cat"><?php echo get_the_terms($featured_post->ID, "category")[0]->name; ?></a>
                                    <?php endif; ?>
                                    <h6 class="sl-title"><a href="<?php echo get_the_permalink($featured_post->ID); ?>"><?php echo get_the_title($featured_post->ID); ?></a></h6>
                                </div>
                                <?php $i++; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php if( $featured_topic_2->term_id ): ?>
                            <a href="<?php echo get_term_link($featured_topic_2->term_id); ?>" class="txt-link blue"><?php _e( 'View All', 'streetleverage-tools' ); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
                <div class="sl-go-deeper-find-more four columns">
                        <h6 class="sl-title"><?php _e("Find More Goodness"); ?></h6>
                            <?php if( $subtopics ): ?>
               
                            <?php foreach( $subtopics as $subtopicID) : ?>
                                <?php if(!in_array( $subtopicID, $featured_topics )) : ?>
                                     <?php $subtopic = get_term_by('id', $subtopicID, 'category'); ?>
                                    <?php if ( $subtopic->term_id != $cat_exclude->term_id ) : ?>
                                        <div class="sl-go-deeper-find-more-subtopic">
                                            <a href="<?php echo get_term_link($subtopic) ?>" class="button orange"><?php echo $subtopic->name; ?></a>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                
                            <?php endif; ?>
            </div>
        </div>
    
    <?php endif; ?>
    </div>
<?php endif; ?>
