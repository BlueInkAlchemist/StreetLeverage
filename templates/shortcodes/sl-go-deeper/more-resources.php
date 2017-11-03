<?php
global $post;
global $wp_query;

if( is_category() ) {
    $category = $wp_query->get_queried_object();
    $more_resources = get_field( 'more-resources', 'category_' . $category->term_id );

} else {
    $more_resources = get_field('more-resources');
}


?>

<div class="sl-go-deeper-more-resources-wrapper">

     <h6 class="sl-title"><?php _e("More Resources"); ?></h6>
    <?php if(have_rows('more-resources')) : ?>
        <?php foreach($more_resources as $resource) : ?>
            <?php setup_postdata( $resource ); ?>
            <div class="sl-more-resources-link">
            <h4><a href="<?php the_permalink(); ?>" class="txt-link"><?php the_title(); ?></a></h4>
            <div><?php the_field('more_resources'); ?></div>
            </div>
            <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
