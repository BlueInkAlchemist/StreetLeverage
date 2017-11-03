<?php
$perpage = 20;
if( get_query_var('paged') ) {
    $page = get_query_var('paged');
} else {
    $page = 1;
}
// $category = $_GET['topic'];
$type = $_GET['type'];
$userid = get_the_author_meta( 'ID' );
// var_dump($userid);
$args = array(
    'post_status' => 'publish',
    'posts_per_page' => $perpage,
    // 'cat' => $category,
    'post_type' => $type,
    'author' => $userid,
);
if( $page > 1 ) {
    $args['offset'] = ($perpage * $page) - $perpage;
}


$archive_query = new WP_Query( $args );
$i = 0;
?>

<?php if( $archive_query->have_posts() ): ?>
    <h3 class="sl-section-title">More articles by <?php echo get_the_author_meta( 'display_name' ); ?></h3>
    <div class="row">

        <?php while( $archive_query->have_posts() ): ?>

            <?php $archive_query->the_post(); ?>

            <?php 
                $title_check = get_the_title( get_the_ID() );
                if ($title_check != "Auto Draft"):
            ?>

            <div class="sl-archive-post-wrapper three columns matchheight sl-box-post">
                <span class="sl-border-hover"></span>
                <div class="sl-feat-img">
                    <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), 'featimg' ); ?></a>
                </div>
                <div class="sl-box">
                    <div class="sl-like-button"><?php SL_Helper::the_like_button($latest_post->ID); ?></div>
                    <?php if( get_the_terms( get_the_ID(), "category" ) ) : ?>
                        <a href="<?php echo get_term_link( get_the_terms( get_the_ID(), "category")[0] ); ?>" class="sl-topic-cat"><?php echo get_the_terms( get_the_ID(), "category" )[0]->name; ?></a>
                    <?php endif; ?>
                    <h4 class="sl-title"><a href="<?php echo get_the_permalink( get_the_ID() ); ?>"><?php echo get_the_title( get_the_ID() ); ?></a></h4>
                    
                </div>
            </div>

            <?php endif; ?>

            <?php $i++ ?>
            <?php if( $i == 12 ) : ?>
                <?php break; ?>
            <?php elseif( $i % 4 == 0 ): ?>
                </div><div class="row">
            <?php endif; ?>
        
        <?php endwhile; ?>

    </div>

    
<?php endif; ?>

