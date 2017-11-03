<?php
$perpage = 20;
if( get_query_var('paged') ) {
    $page = get_query_var('paged');
} else {
    $page = 1;
}
if ( $_GET ) {
    $category = $_GET['topic'];
    $type = $_GET['type'];
    $get_vars = '?';
    foreach ( $_GET as $key=>$value) {
        $get_vars .= $key;
        $get_vars .= '=';
        $get_vars .= $value;
        $get_vars .= '&';
    }
} else {
    $category = null;
    $type = null;
    $get_vars = '';
}
if ( $type == '' ) {
    $url_parse = wp_parse_url( get_permalink() );
    $url_path = $url_parse['path'];
    if ( $url_path == '/more-resources/') {
        $type = 'more_resources';
    } else {
        $type = array( 'post', 'events', 'podcasts', 'scenarios', 'live_presentations' );
    }
}
$args = array(
    'post_status' => 'publish',
    'posts_per_page' => $perpage,
    'cat' => $category,
    'post_type' => $type,
    'orderby' => "post_date", 
    'order' => "DESC",
);
if( $page > 1 ) {
    $args['offset'] = ($perpage * $page) - $perpage;
}
$archive_query = new WP_Query( $args );
$i = 0;
?>

<?php if( $archive_query->have_posts() ): ?>

    <div class="row archive">

        <?php while( $archive_query->have_posts() ): ?>

            <?php $archive_query->the_post(); ?>

            <div class="sl-archive-post-wrapper three columns matchheight sl-box-post">
                <span class="sl-border-hover"></span>
                <div class="sl-feat-img">
                    <?php if( get_the_post_thumbnail( get_the_ID(), 'featimg' ) ) : ?>
                        <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), 'featimg' ); ?></a>
                    <?php else : ?>
                        <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo wp_get_attachment_url( 21657 ); ?>" /></a>
                    <?php endif; ?>
                </div>
                <div class="sl-box">
                    <div class="sl-like-button"><?php SL_Helper::the_like_button( get_the_ID() ); ?></div>
                    <?php if( get_the_terms( get_the_ID(), "category" ) ) : ?>
                        <a href="<?php echo get_term_link( get_the_terms( get_the_ID(), "category")[0] ); ?>" class="sl-topic-cat"><?php echo get_the_terms( get_the_ID(), "category" )[0]->name; ?></a>
                    <?php endif; ?>
                    <h4 class="sl-title"><a href="<?php echo get_the_permalink( get_the_ID() ); ?>"><?php echo get_the_title( get_the_ID() ); ?></a></h4>
                    <a href="<?php get_author_posts_url( the_author_meta( 'ID' ) ) ?>"></a><span class="sl-author"><?php echo __( 'By: ', 'streetleverage-tools' ) . get_the_author(); ?></span></a>
                </div>
            </div>

            <?php $i++ ?>
            <?php if( $i % 4 == 0 ): ?>
                </div><div class="row">
            <?php endif; ?>
        
        <?php endwhile; ?>

    </div>

    <?php wp_reset_postdata(); ?>

    <?php $numpages = $archive_query->max_num_pages; ?>

    <?php if( $numpages > 1 ): ?>

        <div class="pagination">

            <?php if( $page!=1 ): ?>
                <a href="<?php echo get_permalink() . "page/" . ($page-1) ?><?php echo $get_vars; ?>"><?php _e( 'Previous', 'streetleverage-tools' ); ?></a>
                <a href="<?php echo get_permalink() . "page/1" ?><?php echo $get_vars; ?>">1</a>
            <?php endif; ?>

            <?php if( $page > 6 ): ?>

                <span>...</span>

            <?php endif; ?>

            <?php for( $i=4; $i!=0; $i-- ): ?>

                <?php if($page-$i>1): ?>

                    <a href="<?php echo get_permalink() . "page/" . ($page-$i) ?><?php echo $get_vars; ?>"><?php echo $page - $i; ?></a>

                <?php endif; ?>

            <?php endfor; ?>

            <a href="<?php echo get_permalink() . "page/" . ($page) ?><?php echo $get_vars; ?>" class="current"><?php echo $page; ?></a>

            <?php for( $i=1; $i!=5 && $page+$i<$numpages; $i++ ): ?>

                <a href="<?php echo get_permalink() . "page/" . ($page+$i) ?><?php echo $get_vars; ?>"><?php echo $page + $i; ?></a>

                <?php if( $i==4 && $numpages-1>$page+$i ): ?>
                    <span>...</span>
                <?php endif; ?>

            <?php endfor; ?>

            <a href="<?php echo get_permalink() . "page/" . $numpages ?><?php echo $get_vars; ?>"><?php echo $numpages; ?></a>

            <a href="<?php echo get_permalink() . "page/" . ($page+1) ?><?php echo $get_vars; ?>"><?php _e( 'Next', 'streetleverage-tools' ); ?></a>

        </div>

    <?php endif; ?>

<?php endif; ?>

