<?php

global $post;
global $wp_query;

if( is_category() ) {
    $category = $wp_query->get_queried_object();
    if( !get_term_children( $category->term_id, 'category' ) ) {
        $is_child = true;
        $parent_topic_id = $category->parent;
        $parent_topic = get_term($parent_topic_id, 'category');
    } else {
        $is_child = false;
        $parent_topic_id = $category->term_id;
        $parent_topic = get_term($parent_topic_id, 'category');
    }
}

if( $parent_topic_id ) {
    $subtopics = get_term_children( $parent_topic_id, 'category' );
} else {
    $subtopics = get_term_children(get_the_terms($post->ID, 'category')[0]->term_id, 'category');
}

$current_topic = $category->name;

?>

<div class="sl-topics-menu-wrapper">

    <ul class="sl-topics-menu">

        <li class="parent-topic">
            
            <a href="<?php get_term_link( $parent_topic, 'category' ); ?>" <?php if ( $parent_topic->name == $current_topic ) : ?>style="font-weight:700!important;"<?php endif; ?>><?php echo $parent_topic->name; ?></a>
            
            <ul class="sl-subtopics-menu">

                <?php foreach( $subtopics as $subtopic ): ?>

                    <li><a href="<?php echo get_term_link( $subtopic, 'category' ); ?>" <?php if ( get_term( $subtopic, 'category' )->name == $current_topic ) : ?>style="font-weight:900!important;"<?php endif; ?>><?php echo get_term( $subtopic, 'category' )->name; ?></a></li>

                <?php endforeach; ?>

            </ul>

        </li>

    </ul>

</div>