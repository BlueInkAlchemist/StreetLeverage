<?php


class SL_Helper
{

    protected static $instance = null;

    private function __construct() {

        add_filter('get_avatar', array($this, 'custom_avatar'), 10, 6);
        add_filter('get_avatar_url', array($this, 'custom_url'), 10, 3);
        add_filter( 'login_redirect', array($this, 'custom_login_page'), 1, 3 );
        add_action( 'wp_logout', array($this, 'custom_logout_page'), 10 );

    }

    public static function get_instance() {
        if(null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public static function sl_get_the_excerpt($sl_post_id) {
        if($sl_post_id) {
            $sl_post = get_post($sl_post_id);
        } else {
            global $post;
            $sl_post = $post;
        }
        $excerpt = $sl_post->post_excerpt;
        if(!$excerpt) {
            $excerpt = get_post_field( 'post_content', $sl_post_id );
        }
        $excerpt = strip_shortcodes( $excerpt );
        $excerpt = apply_filters( 'the_content', $excerpt );
        $excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
        $excerpt_length = apply_filters( 'excerpt_length', 20 );
        $excerpt = wp_trim_words( $excerpt, $excerpt_length );
        return $excerpt;
    }

    public static function max_title_length( $title ) {
        $max = 70;        
        if( strlen( $title ) > $max ) {
            return substr( $title, 0, strrpos($title, ' ', -20)) . "&hellip;";
        } else {
            return $title;
        }
    }

    public static function get_primary_topic( $sl_post_id ) {
        if(get_field('primary-trending-sub-topic', $sl_post_id)) {
            return get_field('primary-trending-sub-topic', $sl_post_id);
        } else {
            return get_the_terms( $sl_post_id, "category")[0];
        }
    }

    public function custom_avatar( $avatar, $id_or_email, $size, $default, $alt, $args ) {
      
        $custom_avatar = '';

        if ( is_numeric( $id_or_email ) ) {

            $id = (int) $id_or_email;
            $user = get_user_by( 'id' , $id );

        } elseif ( is_object( $id_or_email ) ) {

            if ( ! empty( $id_or_email->user_id ) ) {
                $id = (int) $id_or_email->user_id;
                $user = get_user_by( 'id' , $id );
            }

        } else {
            $user = get_user_by( 'email', $id_or_email );	
        }
        
        
        if ( $user && is_object( $user ) ) {
            
            $avatar =  get_user_meta($user->data->ID, 'gf_avatar')[0];
            $alt = get_user_meta($user->data->ID, 'nickname')[0];
            $size = 64;
            $custom_avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
            

        }
        
        return $custom_avatar;
      
    }

    public function custom_url( $url, $id_or_email, $args ) {
        $url = '';

        if ( is_numeric( $id_or_email ) ) {

            $id = (int) $id_or_email;
            $user = get_user_by( 'id' , $id );

        } elseif ( is_object( $id_or_email ) ) {

            if ( ! empty( $id_or_email->user_id ) ) {
                $id = (int) $id_or_email->user_id;
                $user = get_user_by( 'id' , $id );
            }

        } else {
            $user = get_user_by( 'email', $id_or_email );	
        }
        
        
        if ( $user && is_object( $user ) ) {

            if(get_user_meta($user->data->ID, 'gf_avatar')) {

                $url = get_user_meta($user->data->ID, 'gf_avatar')[0];

            }

        }

        return $url;
    }

    public function custom_login_page( $redirect_to, $request, $user) {
        $login_url = network_site_url( '/member-home/' );
        return $login_url;
    }

    public function custom_logout_page() {
        wp_safe_redirect( home_url() );
        exit;
    }

    public static function the_like_button( $post_id ) {
        if ( is_user_logged_in() ) {
            echo do_shortcode( '[favorite_button post_id="' . $post_id . '"]' );
        } else {
            echo '<a href="#" class="sl-like-logged-out"><i class="fa fa-star" aria-hidden="true"></i></a>';
            echo '<div class="like-login sl-hide"><a href="/login/?redirect_to=' . urlencode(get_permalink()) . '">Sign In</a> or <a href="/sign-up/">Join Now</a> to save your favorite content.</div>';;
        }
    }

    public function sl_shortcode_login_redirect_url( $args ) {

        // die( $args );
        
        if ( $_GET['redirect_to' ]) {
            $args["login_redirect"] = $_GET['redirect_to'];
        } else {
            $args["login_redirect"] = network_site_url( '/member-home/' );
        }
        
        return $args;
    }

}