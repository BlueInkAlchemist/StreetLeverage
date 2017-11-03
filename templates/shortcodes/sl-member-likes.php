<?php
$favorites = array_reverse(get_user_favorites());
// print_r($favorites);
$perm = get_permalink( );
$perpage = 20;
if ( $favorites ) : // This is important: if an empty array is passed into the WP_Query parameters, all posts will be returned
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; // If you want to include pagination
if( $paged > 1 ) {
    $offset = ($perpage * $paged) - $perpage;
}
$favorites_query = new WP_Query(array(
	'post_type' => 'post', // If you have multiple post types, pass an array
	'posts_per_page' => $perpage,
	'ignore_sticky_posts' => true,
	'post__in' => $favorites,
	'paged' => $paged, // If you want to include pagination, and have a specific posts_per_page set
    'offset' => $offset
));
$i = 0;
?>

<div class="sl-member-likes-wrapper">

        <div class="row">

<?php if( $favorites_query->have_posts() ) : while ( $favorites_query->have_posts() ) : $favorites_query->the_post(); ?>

    

            <?php // foreach( $favorites as $favorite ): ?>

                <div class="sl-likes-post-wrapper three columns matchheight sl-box-post">
                    <span class="sl-border-hover"></span>
                    <div class="sl-feat-img">
                        <a href="<?php echo get_the_permalink( $favorite ); ?>"><?php echo get_the_post_thumbnail( $favorite, 'featimg' ); ?></a>
                    </div>
                    <div class="sl-box">
                        <div class="sl-like-button"><?php SL_Helper::the_like_button($favorite); ?></div>
                        <?php if( SL_Helper::get_primary_topic($favorite) ) : ?>
                            <a href="<?php echo get_term_link( SL_Helper::get_primary_topic($favorite) ); ?>" class="sl-topic-cat"><?php echo SL_Helper::get_primary_topic($favorite)->name; ?></a>
                        <?php endif; ?>
                        <h4 class="sl-title"><a href="<?php echo get_the_permalink( $favorite ); ?>"><?php echo get_the_title( $favorite ); ?></a></h4>
                        <a href="<?php echo get_author_posts_url(get_post($favorite)->post_author) ?>">
                            <span class="sl-author"><?php echo __( 'By: ', 'streetleverage-tools' ) . get_userdata(get_post($favorite)->post_author)->display_name; ?></span>
                        </a>
                    </div>
                </div>

            <?php $i++ ?>
          
            <?php if( $i % 4 == 0 ): ?>
                </div><div class="row">
            <?php endif; ?>

            <?php // endforeach; ?>

       

<?php endwhile; ?>

<?php // wp_reset_postdata(); ?>

 <?php $numpages = $favorites_query->max_num_pages; ?>

    <?php if( $numpages > 1 ): ?>

        <div class="pagination">

            <?php if( $paged!=1 ): ?>
                <a href="<?php echo $perm . "page/" . ($paged-1) ?>"><?php _e( 'Previous', 'streetleverage-tools' ); ?></a>
                <a href="<?php echo $perm . "page/1" ?>">1</a>
            <?php endif; ?>

            <?php if( $paged > 6 ): ?>

                <span>...</span>

            <?php endif; ?>

            <?php for( $i=4; $i!=0; $i-- ): ?>

                <?php if($paged-$i>1): ?>

                    <a href="<?php echo $perm . "page/" . ($paged-$i) ?>"><?php echo $paged - $i; ?></a>

                <?php endif; ?>

            <?php endfor; ?>

            <a href="<?php echo $perm . "page/" . ($paged) ?>" class="current"><?php echo $paged; ?></a>

            <?php for( $i=1; $i!=5 && $paged+$i<$numpages; $i++ ): ?>

                <a href="<?php echo $perm . "page/" . ($paged+$i) ?>"><?php echo $paged + $i; ?></a>

                <?php if( $i==4 && $numpages-1>$paged+$i ): ?>
                    <span>...</span>
                <?php endif; ?>

            <?php endfor; ?>

            <?php if ( $paged != $numpages ): ?>
                <a href="<?php echo $perm . "page/" . $numpages ?>"><?php echo $numpages; ?></a>

                <a href="<?php echo $perm . "page/" . ($paged+1) ?>"><?php _e( 'Next', 'streetleverage-tools' ); ?></a>
            <?php endif; ?>
        </div>

    <?php endif; ?>

<?php
endif; wp_reset_postdata();
else :
	// No Favorites
endif; ?>

 </div>

    </div>
