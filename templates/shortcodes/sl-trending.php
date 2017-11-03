<?php

global $wp_query;

$trending_helper = SL_Trending_Helper::get_instance();

$trending_atts = shortcode_atts(array(
    'location' => 'homepage',
    'category' => '',
    'type' => array( 'post', 'events', 'podcasts', 'scenarios', 'live_presentations' )
), $atts, $tag);

$user_id = get_current_user_id();

$gf_content_array = get_user_meta($user_id, 'gf_content');
$gf_content_xploded = array_map('intval', explode(", ", $gf_content_array[0]));

$trending_title = false;

if( $trending_atts['location'] == 'homepage' ) {
    $trending_posts = $trending_helper->getTrendingPosts(4);
    $trending_title = true;
} else if( $trending_atts['location'] == 'archive' ) {
    if ( $trending_atts['category'] ) {
        $trending_posts = $trending_helper->getTrendingPosts(4, array( $trending_atts['category'] ) );
    }
    if ( $trending_atts['type'] ) {
        $trending_posts = $trending_helper->getTrendingPosts(5, '', $trending_atts['type']);
        if ( $trending_atts['type'] == 'scenarios' ) {
            $trending_title = true;
        }
    }
} else if ($trending_atts['location'] == 'topic-page' ) {
    if ( $trending_atts['category'] ) {
        $trending_posts = $trending_helper->getTrendingPosts(4, array( $trending_atts['category'] ) );
    } else {
        $trending_posts = $trending_helper->getTrendingPosts(4, array( $wp_query->get_queried_object()->term_id ), $trending_atts['type'] );
    }
} else if ($trending_atts['location'] == 'member' ) {
    $trending_posts = $trending_helper->getTrendingPosts(4, $gf_content_xploded);
    $trending_title = true;
} else {
    $trending_posts = $trending_helper->getTrendingPosts(4, $trending_atts['category']);
}

$i = 1;

?>

<div class="sl-trending-section-wrapper">
        <?php if ( $trending_title ) : ?>
        <h2 style="padding-bottom:10px;">Trending</h2>
        <?php endif; ?>

        <?php foreach( $trending_posts as $trending_post ) : ?>

            <?php 
                $trending_title = SL_Helper::max_title_length(get_the_title( $trending_post->ID )); 
            ?>

            <?php if( $i == 1 ): ?>
                <div class="sl-trending-post-wrapper sl-trending-post-<?php echo $i; ?> sl-box-post featured matchheight">
                    <span class="sl-border-hover"></span>
                    <a style="display:block" href="<?php echo get_the_permalink( $trending_post->ID ); ?>"><div class="sl-feat-img" style="background: url(<?php echo get_the_post_thumbnail_url( $trending_post->ID, 'featimg' ); ?>); background-repeat: no-repeat; background-size: cover; background-position: top center;"></div></a>
                    <div class="sl-box">
                        <div class="sl-like-button"><?php SL_Helper::the_like_button($trending_post->ID); ?></div>
                        <?php if(get_the_terms( $trending_post->ID, "category")) : ?>
                            <a href="<?php echo get_term_link( get_the_terms( $trending_post->ID, "category")[0] ); ?>" class="sl-topic-cat"><?php echo get_the_terms( $trending_post->ID, "category" )[0]->name; ?></a>
                        <?php endif; ?>
                        <h4 class="sl-title"><a href="<?php echo get_the_permalink( $trending_post->ID ); ?>"><?php echo $trending_title; ?></a></h4>
                        <span class="sl-excerpt"><?php echo SL_Helper::sl_get_the_excerpt( $trending_post->ID ); ?></span>
                        <a href="<?php echo get_author_posts_url($trending_post->post_author) ?>">
                            <span class="sl-author">
                                <?php echo __( 'By: ', 'streetleverage-tools' ) . get_userdata($trending_post->post_author)->display_name; ?>
                            </span>
                        </a>
                    </div>
                </div>

            <?php else: ?>
                <?php if( $i == 2 ): ?><div class="row"><?php endif; ?>
                <div class="sl-trending-post-wrapper sl-trending-post-<?php echo $i; ?> sl-box-post<?php if( $i > 1 ): ?> <?php if($trending_atts['location']=='homepage'): ?>four<?php elseif($trending_atts['location']=='member'): ?>four<?php elseif($trending_atts['location']=='topic-page'): ?>four<?php else: ?>three<?php endif; ?> columns<?php endif; ?> matchheight">
                    <span class="sl-border-hover"></span>
                    <div class="sl-feat-img">
                        <a href="<?php echo get_the_permalink( $trending_post->ID ); ?>"><?php echo get_the_post_thumbnail( $trending_post ); ?></a>
                    </div>
                    <div class="sl-box">
                        <div class="sl-like-button"><?php SL_Helper::the_like_button($trending_post->ID); ?></div>
                        <?php if(get_the_terms( $trending_post->ID, "category")) : ?>
                            <a href="<?php echo get_term_link( get_the_terms( $trending_post->ID, "category")[0] ); ?>" class="sl-topic-cat"><?php echo get_the_terms( $trending_post->ID, "category" )[0]->name; ?></a>
                        <?php endif; ?>
                        <h4 class="sl-title"><a href="<?php echo get_the_permalink( $trending_post->ID ); ?>"><?php echo $trending_title; ?></a></h4>
                        <a href="<?php echo get_author_posts_url($trending_post->post_author) ?>">
                            <span class="sl-author">
                                <?php echo __( 'By: ', 'streetleverage-tools' ) . get_userdata($trending_post->post_author)->display_name; ?>
                            </span>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <?php $i++; ?>

        <?php endforeach; ?>
    
        <?php if($i>2) : ?>
        </div>
        <?php endif; ?>


</div>
