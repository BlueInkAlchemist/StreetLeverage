<?php


class SL_Search_Helper
{

    protected static $instance = null;

    private function __construct() {

        add_filter( 'query_vars', array($this, 'sl_register_query_vars' ), 10, 1 );
        add_filter( 'pre_get_posts', array($this, 'sl_pre_get_posts'), 1, 1 );

    }

    public static function get_instance() {
        if(null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function get_topics() {

        $topics = get_categories();
        return $topics;

    }

    public function sl_pre_get_posts( $query )
    {

        if ( isset($_GET['s']) && !is_admin() && $query->is_main_query() ) {

            $query->set('posts_per_page', 20);
            if (!empty($_GET['post_type'])) {
                $post_type = get_query_var('post_type');
                $query->set('post_type', $post_type);
            } else {
                $query->set('post_type', array( 'post', 'page', 'podcasts', 'scenarios', 'events', 'collections' ));
            }

            if (!empty($_GET['topic'])) {
                $taxonomy = 'category';
                $field = 'id';
                $terms = get_query_var('topic');
                $tax_query = array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => $field,
                        'terms' => $terms,
                    )
                );
                $query->set('tax_query', $tax_query);
            }

            if (!empty($_GET['author'])) {
                $author__in = $this->sl_get_matching_authors($_GET['author']);
                $query->set('author__in', $author__in);
            }
        }

        return $query;
    }

    public function sl_register_query_vars( $vars ) {
        $vars[] = "post_type";
        $vars[] = "topic";
        $vars[] = "khjgafsjkhlas";
        return $vars;
    }

    private function sl_get_matching_authors( $author_search ) {
        add_filter( 'pre_user_query', array( $this, 'sl_filter_user_query' ) );
        $author_string = sanitize_text_field($author_search);
        $args = array(
            'count_total' => false,
            'search' => sprintf( '*%s*', $author_string ),
            'search_fields' => array(
                'display_name',
                'user_login',),
            'fields' => 'ID',
        );
        $author_matches = get_users( $args );
        return $author_matches;
    }

    /**
     * Modify get_users() to search display_name instead of user_nicename
     */
    public function sl_filter_user_query( &$user_query ) {
        if ( is_object( $user_query ) )
            $user_query->query_where = str_replace( "user_nicename LIKE", "display_name LIKE", $user_query->query_where );
        return $user_query;
    }

}