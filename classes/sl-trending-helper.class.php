<?php

class SL_Trending_Helper
{

    protected static $instance = null;

    private function __construct() {

        add_action( 'favorites_after_favorite', array( $this, 'insert_like_record' ), 99, 4 );
        add_action( 'wp_insert_comment', array( $this, 'insert_comment_record' ), 99, 2 );
        add_action( 'template_redirect', array( $this, 'insert_view_record' ), 99 );

        //Add admin menu to set variables
        require_once( plugin_dir_path( __FILE__ ) . "/admin-menus/sl-trending-options.class.php" );
        SL_Trending_Options::get_instance();;

        //Schedule to recalculate all scores daily
        //wp_schedule_event(time(), 'daily', array( $this, 'scheduled_loop' ) );

    }

    public static function get_instance() {
        if( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function insert_share_record( $post_id ) {

        global $wpdb;

        $table_name = $wpdb->prefix . 'sl_trending_data';

        $wpdb->insert(
            $table_name,
            array(
                'time' => current_time( 'mysql' ),
                'post_id' => $post_id,
                'interaction' => 'share',
            )
        );

        update_post_meta($post_id, 'sl_trending_score', self::calculateScore($post_id));

    }

    public function insert_like_record( $post_id, $status, $siteid, $user ) {

        global $wpdb;

        $table_name = $wpdb->prefix . 'sl_trending_data';

        $wpdb->insert(
            $table_name,
            array(
                'time' => current_time( 'mysql' ),
                'post_id' => $post_id,
                'interaction' => 'like',
            )
        );

        update_post_meta($post_id, 'sl_trending_score', self::calculateScore($post_id));

    }

    public function insert_comment_record( $commentID, $comment ) {

        $post_id = $comment->comment_post_ID;

        global $wpdb;

        $table_name = $wpdb->prefix . 'sl_trending_data';

        $wpdb->insert(
            $table_name,
            array(
                'time' => current_time( 'mysql' ),
                'post_id' => $post_id,
                'interaction' => 'comment',
            )
        );

        update_post_meta($post_id, 'sl_trending_score', self::calculateScore($post_id));
    }

    public function insert_view_record() {

        if( is_single ) {
            if( !current_user_can('administrator') || !current_user_can('editor') ) {

                global $wpdb;
                $post_id = get_the_ID();

                $table_name = $wpdb->prefix . 'sl_trending_data';

                $wpdb->insert(
                    $table_name,
                    array(
                        'time' => current_time('mysql'),
                        'post_id' => $post_id,
                        'interaction' => 'view',
                    )
                );

                update_post_meta($post_id, 'sl_trending_score', self::calculateScore($post_id));
            }
        }
    }

    public function scheduledLoop() {

        $trending_posts = self::getTrendingPosts();

        foreach ( $trending_posts as $trending_post ) {
            update_post_meta($trending_post->ID, 'sl_trending_score', self::calculateScore($trending_post->ID));
        }

    }

    public static function getTrendingPosts( $numposts, $topic = array(), $posttype = 'any' ) {

        $args = array(
            'post_status' => 'publish',
            'posts_per_page' => $numposts,
            'post_type' => $posttype,
            'meta_key' => 'sl_trending_score',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        );
        if($topic) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $topic,
                    'operator' => 'IN',
                ),
            );
        }
        
        $trending_posts_query = new WP_Query($args);
        $trending_posts = $trending_posts_query->posts;
        return $trending_posts;

    }

    public static function calculateScore($post_id) {

        global $wpdb;

        $numdays = get_option(sl_trending_days);
        $viewweight = get_option(sl_trending_view_weight);
        $shareweight = get_option(sl_trending_share_weight);
        $commentweight = get_option(sl_trending_comment_weight);
        $likeweight = get_option(sl_trending_like_weight);

        $viewsql = "SELECT COUNT(*) FROM wp_sl_trending_data WHERE post_id=" . $post_id . " AND interaction LIKE 'view' AND time>=DATE_SUB(SYSDATE(), INTERVAL " . $numdays . " DAY);";

        $sharesql = "SELECT COUNT(*) FROM wp_sl_trending_data WHERE post_id=" . $post_id . " AND interaction LIKE 'share' AND time>=DATE_SUB(SYSDATE(), INTERVAL " . $numdays . " DAY);";

        //LEGACY COMMENT DATA - USING EXISTING COMMENTS
        $commentsql = "SELECT COUNT(*) FROM wp_comments WHERE comment_post_ID=" . $post_id . " AND comment_date>=DATE_SUB(SYSDATE(), INTERVAL " . $numdays . " DAY);";

        //UNCOMMENT TO USE NEW DATA
        //$commentsql = "SELECT COUNT(*) FROM wp_sl_trending_data WHERE post_id=802 AND interaction LIKE 'comment' AND time>=DATE_SUB(SYSDATE(), INTERVAL " . $numdays . " DAY);";

        $likesql = "SELECT COUNT(*) FROM wp_sl_trending_data WHERE post_id=802 AND interaction LIKE 'like' AND time>=DATE_SUB(SYSDATE(), INTERVAL " . $numdays . " DAY);";

        $numviews = reset(reset($wpdb->get_results($viewsql, ARRAY_A)));
        $numshares = reset(reset($wpdb->get_results($sharesql, ARRAY_A)));
        $numcomments = reset(reset($wpdb->get_results($commentsql, ARRAY_A)));
        $numlikes = reset(reset($wpdb->get_results($likesql, ARRAY_A)));

        $trendingscore = ($numviews * $viewweight) + ($numshares * $shareweight) + ($numcomments * $commentweight) + ($numlikes * $likeweight);

        //return array('numviews'=>$numviews, 'numshares'=>$numshares, 'numcomments'=>$numcomments, 'numlikes'=>$numlikes, 'numdays'=>$numdays, 'viewweight'=>$viewweight, 'shareweight'=>$shareweight, 'commentweight'=>$commentweight, 'likeweight'=>$likeweight, 'viewsql'=>$viewsql);

        return $trendingscore;

    }


    public static function create_table() {

        global $wpdb;
        $table_name = $wpdb->prefix . 'sl_trending_data';

        if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {
            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
                post_id bigint(20) NOT NULL,
                interaction tinytext NOT NULL,
                PRIMARY KEY (id)
            ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );

        }
    }
    
}
