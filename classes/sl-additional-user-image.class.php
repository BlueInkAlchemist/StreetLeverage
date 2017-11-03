<?php

class SL_Additional_User_Image
{
    protected static $instance = null;

    private $fetched_ids;

    private function __construct() {

        // Hooks
        add_action( 'wp_enqueue_scripts', 'enqueue_userimage_js');
        add_action( 'show_user_profile', 'additional_user_fields' );
        add_action( 'edit_user_profile', 'additional_user_fields' );
        add_action( 'personal_options_update', 'save_additional_user_meta' );
        add_action( 'edit_user_profile_update', 'save_additional_user_meta' );

    }

    public static function get_instance() {
        if(null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function enqueue_userimage_scripts() {
        wp_register_script( 'jquery.userimage', plugins_url( 'jquery.userimage.js', __FILE__ ), array('jquery'), '', true);
        wp_enqueue_script( 'jquery.userimage' );
    }

    /**
 * Adds additional user fields
 * more info: http://justintadlock.com/archives/2009/09/10/adding-and-using-custom-user-profile-fields
 */
 
    public function additional_user_fields( $user ) { ?>
    
        <h3><?php _e( 'Additional User Meta', 'textdomain' ); ?></h3>
    
        <table class="form-table">
    
            <tr>
                <th><label for="user_meta_image"><?php _e( 'A special image for each user', 'textdomain' ); ?></label></th>
                <td>
                    <!-- Outputs the image after save -->
                    <img src="<?php echo esc_url( get_the_author_meta( 'user_meta_image', $user->ID ) ); ?>" style="width:150px;"><br />
                    <!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                    <input type="text" name="user_meta_image" id="user_meta_image" value="<?php echo esc_url_raw( get_the_author_meta( 'user_meta_image', $user->ID ) ); ?>" class="regular-text" />
                    <!-- Outputs the save button -->
                    <input type='button' class="additional-user-image button-primary" value="<?php _e( 'Upload Image', 'textdomain' ); ?>" id="uploadimage"/><br />
                    <span class="description"><?php _e( 'Upload an additional image for your user profile.', 'textdomain' ); ?></span>
                </td>
            </tr>
    
        </table><!-- end form-table -->
    <?php
    }

    /**
    * Saves additional user fields to the database
    */
    public function save_additional_user_meta( $user_id ) {
    
        // only saves if the current user can edit user profiles
        if ( !current_user_can( 'edit_user', $user_id ) )
            return false;
    
        update_usermeta( $user_id, 'user_meta_image', $_POST['user_meta_image'] );
    }

    /**
    * Return an ID of an attachment by searching the database with the file URL.
    *
    * First checks to see if the $url is pointing to a file that exists in
    * the wp-content directory. If so, then we search the database for a
    * partial match consisting of the remaining path AFTER the wp-content
    * directory. Finally, if a match is found the attachment ID will be
    * returned.
    *
    * http://frankiejarrett.com/get-an-attachment-id-by-url-in-wordpress/
    *
    * @return {int} $attachment
    */
    public function get_attachment_image_by_url( $url ) {
    
        // Split the $url into two parts with the wp-content directory as the separator.
        $parse_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );
    
        // Get the host of the current site and the host of the $url, ignoring www.
        $this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
        $file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );
    
        // Return nothing if there aren't any $url parts or if the current host and $url host do not match.
        if ( !isset( $parse_url[1] ) || empty( $parse_url[1] ) || ( $this_host != $file_host ) ) {
            return;
        }
    
        // Now we're going to quickly search the DB for any attachment GUID with a partial path match.
        // Example: /uploads/2013/05/test-image.jpg
        global $wpdb;
    
        $prefix     = $wpdb->prefix;
        $attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM " . $prefix . "posts WHERE guid RLIKE %s;", $parse_url[1] ) );
    
        // Returns null if no attachment is found.
        return $attachment[0];
    }

    /*
    * Retrieve the appropriate image size
    */
    public function get_additional_user_meta_thumb() {
    
        $attachment_url = esc_url( get_the_author_meta( 'user_meta_image', $post->post_author ) );
    
        // grabs the id from the URL using Frankie Jarretts function
        $attachment_id = get_attachment_image_by_url( $attachment_url );
    
        // retrieve the thumbnail size of our image
        $image_thumb = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
    
        // return the image thumbnail
        return $image_thumb[0];
    
    }

}


?>