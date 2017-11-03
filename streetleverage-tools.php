<?php

/*
Plugin Name: Street Leverage Tools
Plugin URI: http://StreetLeverage.com
Description: A set of functions and tools for the operation of the Street Leverage website
Version: 1.3
Author: Josh Loomis
Author URI: http://github.com/BlueInkAlchemist
License: GPL2
*/

register_activation_hook( __FILE__, 'streetleverage_tools_activation' );

require_once( plugin_dir_path( __FILE__ ) . "classes/sl-shortcodes.class.php" );
SL_Shortcodes::get_instance();

require_once( plugin_dir_path( __FILE__ ) . "classes/sl-helper.class.php" );
global $sl_helper;
$sl_helper = SL_Helper::get_instance();

require_once( plugin_dir_path( __FILE__ ) . "classes/sl-trending-helper.class.php" );
global $sl_trending_helper;
$sl_trending_helper = SL_Trending_Helper::get_instance();

require_once( plugin_dir_path( __FILE__ ) . "classes/sl-search-helper.class.php" );
global $sl_search_helper;
$sl_search_helper = SL_Search_Helper::get_instance();

function streetleverage_tools_activation() {

    global $sl_trending_helper;
    $sl_trending_helper->create_table();
    $capabilities = array(
        'read' => true,
        'edit_posts' => true,
        'publish_posts' => true,
        'moderate_comments' => true,
        'delete_posts' => false,
    );
    add_role( 'guest', 'StreetLeverage Guest', $capabilities );

}

add_action( 'wp_enqueue_scripts', 'sl_enqueue_styles' );
function sl_enqueue_styles() {
    wp_enqueue_style( 'sl_styles', plugins_url( 'css/style.css', __FILE__ ), false );
    wp_enqueue_style( 'sl_font_awesome', plugins_url( 'resources/font-awesome-4.6.3/css/font-awesome.css', __FILE__ ), false );
    wp_enqueue_style( 'sl_bx_slider_style', plugins_url( 'resources/bxslider/jquery.bxslider.css', __FILE__ ), false );
    wp_enqueue_script( 'sl_match_height', plugins_url( 'js/jquery.matchHeight-min.js', __FILE__ ), false );
    wp_enqueue_script( 'sl_scripts', plugins_url( 'js/sl-scripts.js', __FILE__ ), false );
    wp_enqueue_script( 'sl_reg_scripts', plugins_url( 'js/sl-reg-scripts.js', __FILE__ ), false );
    wp_enqueue_script( 'sl_bx_slider_script', plugins_url( 'resources/bxslider/jquery.bxslider.min.js', __FILE__ ), false );
}

add_action( 'wp_footer', 'sl_share_popup' );
function sl_share_popup() {
    if( is_single() ) {
        include(WP_PLUGIN_DIR . "/streetleverage-tools/templates/sl-share-popup.php");
    }
}

if ( function_exists( 'add_image_size' ) ) add_theme_support( 'post-thumbnails' );
add_image_size( 'featimg', 550, 340, true );

// on request for wp-login, redirect to /login/ for GF 
add_action( 'init','sl_redirect_login_page' );
function sl_redirect_login_page() {
    // Store for checking if this page equals wp-login.php
    global $pagenow;
    
    // permalink to the custom login page
    $login_page  = get_permalink( 17557 );
    //echo "<script>console.log('" . $_POST . "')</script>";
    if ( 'wp-login.php' == $pagenow ) {
        //if(!is_user_logged_in()) {
        
        if( count( $_POST ) < 2 && count( $_GET ) < 2 ) {
            //echo ( count($_POST) );
            if( isset( $_POST['redirect_to'] ) || count( $_POST ) == 0 ) {
                if( isset( $_GET['redirect_to'] ) || count( $_GET ) == 0 ) {
                    //echo ( 'redirecting ');
                    if( isset( $_POST['redirect_to'] ) ) {
                        $login_page .= "?redirect_to=" . $_POST['redirect_to'];
                    } else if ( isset( $_GET['redirect_to'] ) ) {
                        $login_page .= "?redirect_to=" . $_GET['redirect_to'];
                    }
                    wp_redirect( $login_page );
                    exit();
                }
            }
        }
    }
}

// Filter wpdiscuz author labels
// add_filter( 'wpdiscuz_author_title', 'wpdiscuz_filter_labels' );
// function wpdiscuz_filter_labels( $author_title, $comment )
// {
//     $author_title = null;

//     return $author_title;
// }

// exclude More Resources 
add_action( 'pre_get_posts', 'more_resources_pre_get_posts' );
function more_resources_pre_get_posts( $query ) 
{
  // only for feeds
  if( !$query->is_feed || !$query->is_main_query() )
    return query;

  $exclude = 'more_resources';
  $post_types = $query->get('post_type');

  if ( ( $key = array_search( $exclude, $post_types ) ) !== false )
    unset( $post_types[$key] );

    $query->set( 'post_type', $post_types );

    return $query;
}

// the_content filter
function wpa_content_filter( $content ) {
    global $post;
    if( $meta = get_post_meta( $post->ID, 'video_embed', true ) ) {
        $video_code = reset(get_post_meta( get_the_ID(), 'video_embed' ));
        $video_embed = '<div class="sl-post-video video-container">';
        $video_embed .= $video_code;
        $video_embed .= '</div>';
        return $video_embed . $content;
    }
    return $content;
}
add_filter( 'the_content', 'wpa_content_filter', 10 );

// our version of the browser's "Back" button
add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

function myStartSession() {
    if(!session_id()) {
        session_start();
        if(!isset($_SESSION['myKey']))
        {
            $_SESSION['myKey'] = 'A string for testing';
        }
        if(!isset($_SESSION['org_referer']))
        {
            $_SESSION['org_referer'] = $_SERVER['HTTP_REFERER'];
        }
    }
}

function myEndSession() {
    session_destroy ();
}

add_action('check_admin_referer', 'logout_without_confirm', 10, 2);
function logout_without_confirm($action, $result)
{
    /**
     * Allow logout without confirmation
     */
    if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '';
        $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));;
        header("Location: $location");
        die;
    }
}