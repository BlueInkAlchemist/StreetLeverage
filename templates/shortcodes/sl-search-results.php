<?php

$perpage = 12;
if( get_query_var('paged') ) {
    $page = get_query_var('paged');
} else {
    $page = 1;
}

if( $page > 1 ) {
    $args['offset'] = ($perpage * $page) - $perpage;
}

// check for empty search params
$contents = array_filter( $_GET );
if ( $_GET['s'] == '' && $_GET['author'] == '' && $_GET['post_type'] == 'all' && $_GET['topic'] == '') {
    $empty_params = true;
}

global $wp_query;

if ( !empty($contents) && !$empty_params ) {
    $user_arg = get_user_id_by_display_name( $_GET['author'] );
    $post_type = $_GET['post_type'];
    if ($post_type == 'all') {
        $post_type = '';
    }
    $wp_query = new WP_Query( array( 's' => $_GET['s'], 'author' => (int)$user_arg, 'post_type' => $post_type, 'cat' => $_GET['topic'], 'posts_per_page' => 12, 'paged' => $page ) );
    $wp_query->rewind_posts();
    $i = 0;
} else {
    $query_args = ( array( 'post_type' => 'post','podcasts','events','collections', 'posts_per_page' => 12, 'paged' => $page ) );
    $wp_query = new WP_Query( $query_args );
    $wp_query->rewind_posts();
    $i = 0;
}

    ?>

    <?php if( have_posts() ): ?>

        <div class="sl-search-results-wrapper">

            <div class="row">

                <?php while( have_posts() ): ?>
                    
                    <?php the_post(); ?>

                    <div class="sl-search-post-wrapper three columns matchheight sl-box-post">
                        <span class="sl-border-hover"></span>
                        <div class="sl-feat-img">
                            <a href="<?php echo get_the_permalink( get_the_ID() ); ?>"><?php echo get_the_post_thumbnail( get_the_ID() ); ?></a>
                        </div>
                        <div class="sl-box">
                            <div class="sl-like-button"><?php SL_Helper::the_like_button( get_the_ID() ); ?></div>
                            <?php if( get_the_terms( get_the_ID(), "category" ) ) : ?>
                                <a href="<?php echo get_term_link( get_the_terms( get_the_ID(), "category")[0] ); ?>" class="sl-topic-cat"><?php echo get_the_terms( get_the_ID(), "category" )[0]->name; ?></a>
                            <?php endif; ?>
                            <h4 class="sl-title"><a href="<?php echo get_the_permalink( get_the_ID() ); ?>"><?php echo get_the_title( get_the_ID() ); ?></a></h4>
                            <span class="sl-author">
                                <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
                            <?php echo __( 'By: ', 'streetleverage-tools' ) . get_the_author(); ?></a></span>
                        </div>
                    </div>

                <?php $i++ ?>
                <?php if( $i % 4 == 0 ): ?>
                    </div><div class="row">
                <?php endif; ?>

                <?php endwhile; ?>

            </div>

        </div>
        <?php 
            wp_reset_postdata(); 
            global $wp;
            $perm = get_site_url();
        ?>

        <?php $numpages = $wp_query->max_num_pages; ?>

        <?php 
            $key_values = $_GET; 
            $search_string = "?";
            foreach ( $key_values as $key => $value) {
                $search_string .= "&" . $key . "=" . $value;
            }
            
        ?>
        <?php if( $numpages > 1 ): ?>

            <div class="pagination">

                <?php if( $page!=1 ): ?>
                    <a href="<?php echo $perm . "/" . "page/" . ($page-1) . "/" . $search_string ?>"><?php _e( 'Previous', 'streetleverage-tools' ); ?></a>
                    <a href="<?php echo $perm . "/page/1/" . $search_string ?>">1</a>
                <?php endif; ?>

                <?php if( $page > 6 ): ?>

                    <span>...</span>

                <?php endif; ?>

                <?php for( $i=4; $i!=0; $i-- ): ?>

                    <?php if($page-$i>1): ?>

                        <a href="<?php echo $perm . "/" . "page/" . ($page-$i) . "/" . $search_string ?>"><?php echo $page - $i; ?></a>

                    <?php endif; ?>

                <?php endfor; ?>

                <a href="<?php echo $perm . "/" . "page/" . ($page) . "/" . $search_string ?>" class="current"><?php echo $page; ?></a>

                <?php for( $i=1; $i!=5 && $page+$i<$numpages; $i++ ): ?>

                    <a href="<?php echo $perm . "/" . "page/" . ($page+$i) . "/" . $search_string ?>"><?php echo $page + $i; ?></a>

                    <?php if( $i==4 && $numpages-1>$page+$i ): ?>
                        <span>...</span>
                    <?php endif; ?>

                <?php endfor; ?>

                <a href="<?php echo $perm . "/" . "page/" . $numpages . "/" . $search_string ?>"><?php echo $numpages; ?></a>

                <a href="<?php echo $perm . "/" . "page/" . ($page+1) . "/" . $search_string ?>"><?php _e( 'Next', 'streetleverage-tools' ); ?></a>

            </div>

        <?php endif; ?>
    <?php else: ?>

    <div class="plain-text-container">
        <h3 style="text-align:center;">Bummer!</h3>
        <br/>
        <h5 style="text-align:center;">Unfortunately, we couldn't find what you are looking for with the search criteria you have indicated.</h5>
    </div>


    <?php endif; ?>

<?php

function get_user_id_by_display_name( $display_name ) {
    global $wpdb;

    if ( ! $user = $wpdb->get_row( $wpdb->prepare(
        "SELECT `ID` FROM $wpdb->users WHERE `display_name` = %s", $display_name
    ) ) )
        return false;

    return $user->ID;
}

?>