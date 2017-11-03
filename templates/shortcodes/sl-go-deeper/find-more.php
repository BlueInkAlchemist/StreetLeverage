<?php
global $post;
global $wp_query;

if( is_category() ) {
    $category = $wp_query->get_queried_object();
    $featured_topics = array(
        get_field("go-deeper-featured-1", "category_" . $category->term_id)[0]->term_id,
        get_field("go-deeper-featured-2", "category_" . $category->term_id)[0]->term_id,
    );
    $parent_topic_id = $category->term_id;
} else {
    $featured_topics = array(
        get_field('go-deeper-featured-1')[0]->term_id,
        get_field('go-deeper-featured-2')[0]->term_id,
    );
    $parent_topic_id = get_the_terms($post->ID, 'category')[0]->parent;
}


if ($parent_topic_id) {
    $subtopics = get_term_children( $parent_topic_id, 'category' );
}
else {
    $subtopics = get_term_children(get_the_terms($post->ID, 'category')[0]->term_id, 'category');
}
?>



<div class="sl-go-deeper-find-more-wrapper">
    <h6 class="sl-title"><?php _e("Find More Goodness"); ?></h6>

    <?php foreach( $subtopics as $subtopicID) : ?>

        <?php if(!in_array( $subtopicID, $featured_topics )) : ?>

            <?php $subtopic = get_term_by('id', $subtopicID, 'category'); ?>

            <div class="sl-go-deeper-find-more-subtopic">

                <a href="<?php echo get_term_link($subtopic) ?>" class="button white"><?php echo $subtopic->name; ?></a>

            </div>

        <?php endif; ?>

    <?php endforeach; ?>

</div>