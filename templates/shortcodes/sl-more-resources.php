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

if( $display_section ):
    if( is_category() ) {
        $more_resources = get_field( 'more-resources', 'category_' . $category->term_id );
    } else {
        $more_resources = get_field('more-resources');
    }

    $fp1_args = array(
        'category' => $featured_topic_1->term_id,
        'post_status' => 'publish',
        'numberposts' => 2,
    );
    $featured_posts_1 = get_posts($fp1_args);

    $fp2_args = array(
        'category' => $featured_topic_2->term_id,
        'post_status' => 'publish',
        'numberposts' => 2,
    );
    $featured_posts_2 = get_posts($fp2_args);

    $featured_topics = array($featured_topic_1->term_id, $featured_topic_2->term_id);
    if( $parent_topic_id ) {
        $subtopics = get_term_children( $parent_topic_id, 'category' );
    } else {
        $subtopics = get_term_children(get_the_terms($post->ID, 'category')[0]->term_id, 'category');
    }
    ?>
    <?php if( $more_resources ): ?>
            <?php if(have_rows('more-resources')) : ?>
                <div class="sl-go-deeper-more-resources">
                <h2 class="sl-section-title"><?php _e("More Resources"); ?></h2>
                    <?php $i = 0; ?>
                    <div class="row">
                    <?php foreach($more_resources as $resource) : ?>
                        <?php  // echo var_dump($resource); ?>
                        <div class="sl-more-resources-link four columns">
                            <a href="<?php echo get_post_permalink( $resource['resource']->ID ); ?>" class="txt-link blue" target="_blank"><?php echo $resource['resource']->post_title; ?></a>
                        </div>

                        <?php $i++; ?>
                        <?php if($i%3==0): ?>
                            </div><div class="row">
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>