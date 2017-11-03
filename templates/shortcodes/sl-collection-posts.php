<?php
global $post;
if(get_post_type()=='collections'):
    $collection_posts = get_field('collection-posts');
?>

    <div class="sl-collection-posts-wrapper">

        <?php foreach( $collection_posts as $collection_post_array ): ?>
            <?php $collection_post = $collection_post_array['collection-post']; ?>

            <div class="sl-collection-post-wrapper">

                <h2 class="sl-title"><a href="<?php echo get_the_permalink( $collection_post->ID ); ?>" target="_blank"><?php echo get_the_title( $collection_post->ID ); ?></a></h2>
                <div class="sl-excerpt"><?php echo SL_Helper::sl_get_the_excerpt( $collection_post->ID ); ?></div>
                <a href="<?php echo get_the_permalink( $collection_post->ID ); ?>" target="_blank"><?php echo get_the_post_thumbnail( $collection_post ); ?></a>
                <br/><br/>
                <div class="sl-collection-link"><a href="<?php echo get_the_permalink( $collection_post->ID ); ?>" target="_blank">Read More</a></div>

            </div>

        <?php endforeach; ?>

    </div>

<?php endif; ?>