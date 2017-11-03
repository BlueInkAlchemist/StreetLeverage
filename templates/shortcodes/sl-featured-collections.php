<?php

$args = array(
    'post_type' => 'collections',
    'post_status' => 'publish',
    'numberposts' => 3,
);
$featured_collections = get_posts($args);

?>

<div class="sl-featured-collections-section-wrapper">

    <h2 class="sl-featured-collections-section-title"><?php _e( 'Featured Collections', 'streetleverage-tools' ); ?></h2>
    <span class="sl-subtitle"><?php  _e( 'Handpicked insight just for you.', 'streetleverage-tools' ); ?></span>
	<div class="row">
    <?php foreach($featured_collections as $collection): ?>

		<?php $topic_link = get_term_link(get_the_terms($collection->ID, "category")[0]); ?>

        <div class="sl-box-post four columns matchheight">
	        <span class="sl-border-hover"></span>
            <div class="sl-feat-img">
	            <a href="<?php echo get_the_permalink( $collection->ID ); ?>"><?php echo get_the_post_thumbnail( $collection, 'featimg' ); ?></a>
            </div>
            <div class="sl-box">
                <div class="sl-like-button"><?php SL_Helper::the_like_button($collection->ID); ?></div>
				<?php if(get_the_terms($collection->ID, "category")): ?>
					<a href="<?php echo get_term_link(get_the_terms($collection->ID, "category")[0]); ?>" class="sl-topic-cat"><?php echo get_the_terms($collection->ID, "category")[0]->name; ?></a>
				<?php endif; ?>
	            <h5 class="sl-title"><a href="<?php echo get_the_permalink($collection->ID); ?>"><?php echo get_the_title( $collection->ID ); ?></a></h5>
	            <span class="sl-excerpt"><?php echo get_the_excerpt( $collection->ID ); ?></span>
                <a href="<?php echo get_author_posts_url($collection->post_author) ?>">
                    <span class="sl-author">
                        <?php echo __( 'By: ', 'streetleverage-tools' ) . get_userdata($collection->post_author)->display_name; ?>
                    </span>
                </a>
            </div>
        </div>

    <?php endforeach; ?>
	</div>
    <?php if( is_home() ) : ?>
        <br/>
        <br/>
        <p class="text-center sl-featured-collections-link"><a href="http://beta.streetleverage.com/archives/?type=collections&order=DESC">More Featured Collections</a></p>
    <?php endif; ?>
</div>