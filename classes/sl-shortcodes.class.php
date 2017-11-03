<?php

class SL_Shortcodes
{
    protected static $instance = null;

    private function __construct() {

        $this->initiate_shortcodes();

    }

    public static function get_instance() {
        if(null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function initiate_shortcodes() {

        add_shortcode( 'sl_thenetyeti_test', array( $this, 'sl_thenetyeti_test' ) );

        add_shortcode( 'sl_post_title', array( $this, 'sl_post_title' ) );
        add_shortcode( 'sl_behind_the_practice' , array( $this, 'sl_behind_the_practice' ) );
        add_shortcode( 'sl_featured_collections' , array( $this, 'sl_featured_collections' ) );
        add_shortcode( 'sl_go_deeper' , array( $this, 'sl_go_deeper' ) );
        add_shortcode( 'sl_latest' , array( $this, 'sl_latest' ) );
        add_shortcode( 'sl_latest_archive' , array( $this, 'sl_latest_archive' ) );
        add_shortcode( 'sl_reflection_room' , array( $this, 'sl_reflection_room' ) );
        add_shortcode( 'sl_related_insight' , array( $this, 'sl_related_insight' ) );
        add_shortcode( 'sl_trending' , array( $this, 'sl_trending' ) );
        add_shortcode( 'sl_more_in_topic' , array( $this, 'sl_more_in_topic' ) );
        add_shortcode( 'sl_podcast_guest_info' , array( $this, 'sl_podcast_guest_info' ) );
        add_shortcode( 'sl_scenario_guest_info' , array( $this, 'sl_scenario_guest_info' ) );
        add_shortcode( 'sl_author_info' , array( $this, 'sl_author_info' ) );
        add_shortcode( 'sl_sponsored_ad' , array( $this, 'sl_sponsored_ad' ) );
        add_shortcode( 'sl_action_icons' , array( $this, 'sl_action_icons' ) );
        add_shortcode( 'sl_conversation' , array( $this, 'sl_conversation' ) );
        add_shortcode( 'sl_topic_areas', array( $this, 'sl_topic_areas' ) );
        add_shortcode( 'sl_topic_cloud', array( $this, 'sl_topic_cloud' ) );
        add_shortcode( 'sl_our_picks', array( $this, 'sl_our_picks' ) );
        add_shortcode( 'sl_featured_topics_grid', array( $this, 'sl_featured_topics_grid' ) );
        add_shortcode( 'sl_topic_title', array( $this, 'sl_topic_title' ) );
        add_shortcode( 'sl_podcast_video', array( $this, 'sl_podcast_video' ) );
        add_shortcode( 'sl_podcast_shownotes', array( $this, 'sl_podcast_shownotes' ) );
        add_shortcode( 'sl_scenario_video', array( $this, 'sl_scenario_video' ) );
        add_shortcode( 'sl_scenario_transcript', array( $this, 'sl_scenario_transcript' ) );
        add_shortcode( 'sl_collection_posts', array( $this, 'sl_collection_posts' ) );
        add_shortcode( 'sl_more_collections', array( $this, 'sl_more_collections' ) );
        add_shortcode( 'sl_events_slider', array( $this, 'sl_events_slider' ) );
        add_shortcode( 'sl_post_archive', array( $this, 'sl_post_archive' ) );
        add_shortcode( 'sl_author_page_info' , array( $this, 'sl_author_page_info' ) );
        add_shortcode( 'sl_author_posts', array( $this, 'sl_author_posts' ) );
        add_shortcode( 'sl_member_home_header', array( $this, 'sl_member_home_header' ) );
        add_shortcode( 'sl_member_menu', array( $this, 'sl_member_menu' ) );
        add_shortcode( 'sl_member_likes', array( $this, 'sl_member_likes' ) );
        add_shortcode( 'sl_member_recent_likes', array( $this, 'sl_member_recent_likes' ) );
        add_shortcode( 'sl_signup_button', array( $this, 'sl_signup_button' ) );
        add_shortcode( 'sl_search_form', array( $this, 'sl_search_form' ) );
        add_shortcode( 'sl_search_results', array( $this, 'sl_search_results' ) );
        add_shortcode( 'sl_benefactor_bar', array( $this, 'sl_benefactor_bar' ) );
        add_shortcode( 'sl_user_registration', array( $this, 'sl_user_registration' ) );
        add_shortcode( 'sl_dynamic_fields', array( $this, 'sl_dynamic_fields' ) );
        add_shortcode( 'sl_events_display', array( $this, 'sl_events_display' ) );
        add_shortcode( 'sl_connect_network_repeat', array( $this, 'sl_connect_network_repeat' ) );
        add_shortcode( 'sl_topic_preferences_confirmation', array( $this, 'sl_topic_preferences_confirmation' ) );
        add_shortcode( 'sl_login_redirect', array( $this, 'sl_login_redirect' ) );
        add_shortcode( 'sl_show_content', array( $this, 'sl_show_content' ) );
        add_shortcode( 'sl_more_resources', array( $this, 'sl_more_resources' ) );
        add_shortcode( 'sl_post_video', array( $this, 'sl_post_video' ) );
        add_shortcode( 'sl_topics_menu', array( $this, 'sl_topics_menu' ) );
        add_shortcode( 'sl_presentation_shownotes', array( $this, 'sl_presentation_shownotes' ) );
        add_shortcode( 'sl_presentation_video', array( $this, 'sl_presentation_video' ) );
        add_shortcode( 'sl_post_content', array( $this, 'sl_post_content' ) );
        add_shortcode( 'sl_live_back_button', array( $this, 'sl_live_back_button' ) );
        add_shortcode( 'sl_btp_button', array( $this, 'sl_btp_button' ) );
        add_shortcode( 'sl_about_team', array( $this, 'sl_about_team' ) );

    }

    public function sl_thenetyeti_test() {

        echo get_avatar_url( 139 );

    }

    public function sl_post_title() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-post-title.php", false);
        return ob_get_clean();

    }

    public function sl_behind_the_practice( $atts ) {

        ob_start();
        include(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-behind-the-practice.php");
        return ob_get_clean();

    }

    public function sl_featured_collections() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-featured-collections.php", false);
        return ob_get_clean();

    }

    public function sl_go_deeper( $atts ) {

        ob_start();
        include(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-go-deeper.php");
        return ob_get_clean();

        /*
        if ( $atts["section"] == "featured-1" ) {
            ob_start();
            load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-go-deeper/featured-1.php", false);
            return ob_get_clean();
        }

        if ( $atts["section"] == "featured-2" ) {
            ob_start();
            load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-go-deeper/featured-2.php", false);
            return ob_get_clean();
        }

        if ( $atts["section"] == "find-more" ) {
            ob_start();
            load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-go-deeper/find-more.php", false);
            return ob_get_clean();
        }

        if ( $atts["section"] == "more-resources" ) {
            ob_start();
            load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-go-deeper/more-resources.php", false);
            return ob_get_clean();
        }
        */

    }

    public function sl_latest( $atts = [], $content = null, $tag = '' ) {

        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        ob_start();
        include(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-latest.php");
        return ob_get_clean();

    }

    public function sl_latest_archive( $atts = [], $content = null, $tag = '' ) {

        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        ob_start();
        include(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-latest-archive.php");
        return ob_get_clean();

    }

    public function sl_reflection_room() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-reflection-room.php", false);
        return ob_get_clean();

    }

    public function sl_related_insight( $atts = [], $content = null, $tag = '' ) {

        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        ob_start();
        include(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-related-insight.php");
        return ob_get_clean();

    }

    public function sl_trending( $atts = [], $content = null, $tag = '' ) {
        // echo var_dump( $atts );
        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        ob_start();
        include(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-trending.php");
        return ob_get_clean();

    }

    public function sl_more_in_topic() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-more-in-topic.php", false);
        return ob_get_clean();

    }

    public function sl_podcast_guest_info() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-podcast-guest-info.php", false);
        return ob_get_clean();

    }

    public function sl_scenario_guest_info() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-scenario-guest-info.php", false);
        return ob_get_clean();

    }

    public function sl_author_info() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-author-info.php", false);
        return ob_get_clean();

    }

    public function sl_sponsored_ad() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-sponsored-ad.php", false);
        return ob_get_clean();

    }

    public function sl_action_icons() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-action-icons.php", false);
        return ob_get_clean();

    }

    public function sl_conversation() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-conversation.php", false);
        return ob_get_clean();

    }

    public function sl_topic_areas() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-topic-areas.php", false);
        return ob_get_clean();

    }

    public function sl_topic_cloud() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-topic-cloud.php", false);
        return ob_get_clean();

    }

    public function sl_our_picks( $atts = [], $content = null, $tag = '' ) {

        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        ob_start();
        include(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-our-picks.php");
        return ob_get_clean();

    }

    public function sl_featured_topics_grid( $atts = [], $content = null, $tag = '' ) {

        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        ob_start();
        include(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-featured-topics-grid.php");
        return ob_get_clean();

    }

    public function sl_topic_title() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-topic-title.php", false);
        return ob_get_clean();

    }

    public function sl_podcast_video() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-podcast-video.php", false);
        return ob_get_clean();

    }

    public function sl_podcast_shownotes() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-podcast-shownotes.php", false);
        return ob_get_clean();

    }

    public function sl_scenario_video() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-scenario-video.php", false);
        return ob_get_clean();

    }

    public function sl_scenario_transcript() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-scenario-transcript.php", false);
        return ob_get_clean();

    }

    public function sl_collection_posts() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-collection-posts.php", false);
        return ob_get_clean();

    }

    public function sl_more_collections() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-more-collections.php", false);
        return ob_get_clean();

    }

    public function sl_events_slider() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-events-slider.php", false);
        return ob_get_clean();

    }

    public function sl_post_archive() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-post-archive.php", false);
        return ob_get_clean();

    }
    
    public function sl_author_page_info() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-author-page-info.php", false);
        return ob_get_clean();

    }

    public function sl_author_posts() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-author-posts.php", false);
        return ob_get_clean();

    }

    public function sl_member_home_header() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-member-home-header.php", false);
        return ob_get_clean();

    }

    public function sl_member_menu( $atts = [], $content = null, $tag = '' ) {
        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        ob_start();
        include(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-member-menu.php");
        return ob_get_clean();

    }

    public function sl_member_likes() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-member-likes.php", false);
        return ob_get_clean();

    }

    public function sl_member_recent_likes() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-member-recent-likes.php", false);
        return ob_get_clean();

    }

    public function sl_signup_button() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-signup-button.php", false);
        return ob_get_clean();

    }

    public function sl_search_form( $atts = [], $content = null, $tag = '' ) {
        
        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        
        ob_start();
        include(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-search-form.php");
        return ob_get_clean();

    }

    public function sl_search_results() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-search-results.php", false);
        return ob_get_clean();

    }

    public function sl_benefactor_bar() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-benefactor-bar.php", false);
        return ob_get_clean();
    }

    public function sl_user_registration() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-user-registration.php", false);
        return ob_get_clean();

    }

    public function sl_dynamic_fields() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-dynamic-fields.php", false);
        return ob_get_clean();

    }

    public function sl_events_display() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-events-display.php", false);
        return ob_get_clean();

    }

    public function sl_connect_network_repeat() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-connect-network-repeat.php", false);
        return ob_get_clean();

    }

    public function sl_topic_preferences_confirmation() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-topic-preferences-confirmation.php", false);
        return ob_get_clean();

    }

    public function sl_login_redirect() {
        
        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-login-redirect.php", false);
        return ob_get_clean();

    }

    public function sl_show_content() {
        
        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-show-content.php", false);
        return ob_get_clean();

    }

     public function sl_more_resources() {
        
        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-more-resources.php", false);
        return ob_get_clean();

    }

    public function sl_post_video() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-post-video.php", false);
        return ob_get_clean();

    }

    public function sl_topics_menu() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-topics-menu.php", false);
        return ob_get_clean();

    }

    public function sl_presentation_shownotes() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-presentation-shownotes.php", false);
        return ob_get_clean();

    }

    public function sl_presentation_video() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-presentation-video.php", false);
        return ob_get_clean();

    }

    public function sl_post_content() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-post-content.php", false);
        return ob_get_clean();

    }

    public function sl_live_back_button() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-live-back-button.php", false);
        return ob_get_clean();

    }

    public function sl_btp_button() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-btp-button.php", false);
        return ob_get_clean();

    }

    public function sl_about_team() {

        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/shortcodes/sl-about-team.php", false);
        return ob_get_clean();
    }
}