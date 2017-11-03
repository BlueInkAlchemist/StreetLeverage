<?php
global $wp_query;
$search_form_atts = shortcode_atts(array(
    'location' => 'homepage',
    'category' => '',
    'type' => array( 'all', 'post', 'events', 'podcasts', 'scenarios', 'collections', 'more_resources' )
), $atts, $tag);

// Let's get the users
$user_args = array(
    'role__not_in' => 'Subscriber',
);

$user_query = new WP_User_Query( $user_args );

if( $search_form_atts['type'] == 'all' || $search_form_atts['type'] == 'more_resources' ) :
    
    $sl_search_helper = SL_Search_Helper::get_instance();
    $topics = $sl_search_helper->get_topics();
    $post_types = array (
        'all' => 'All Content Types',
        'post' => 'Article',
        'podcasts' => 'Behind The Practice',
        'scenarios' => 'Reflection Room',
        'events' => 'Event',
        'collections' => 'Collection',
        'more_resources' => 'More Resources',
    );


        if ( isset ( $_GET['s'] ) ) {
            $s = $_GET['s'];
        }
        if ( isset ( $_GET['author'] ) ) {
            $author = $_GET['author'];
        }
        if ( isset ( $_GET['post_type'] ) ) {
            $set_post_type = $_GET['post_type'];
        } else {
            $set_post_type = $search_form_atts['type'];
        }
        if ( isset ( $_GET['topic'] ) ) {
            $set_topic = $_GET['topic'];
        }
        
    ?>
    <div class="searchwrap">
        <div class="searchforminnerwrap animated">
            <form action="<?php echo esc_url( home_url() ); ?>" method="GET" role="search">
                <!--Search-->
                <div class="row">
                    <div class="twelve columns">
                        <input class="search-input expanded nomarg borderblue" name="s" placeholder="<?php _e('What can we help you find?', 'streetleverage-tools'); ?>" value="<?php if($s) { _e($s, 'streetleverage-tools'); } ?>" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="columns four">
                        <div class="select">
                            <select name="author">
                            <option selected value="">
                                    <?php _e('All Authors', 'streetleverage-tools') ?>
                                </option>
                            <?php foreach($user_query->results as $user): ?>
                                    <option <?php if ($user->display_name == $author) { ?> selected <?php } ?> value="<?php echo $user->display_name; ?>">
                                        <?php echo $user->display_name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="select__arrow"></div>
                        </div>
                        <!-- <input class="search-text-input" name="author" placeholder="All Authors" value="<?php // if($author) { _e($author, 'streetleverage-tools'); } ?>" type="text"> -->
                    </div>
                    <div class="four columns">
                        <div class="select">
                                <select name="post_type">
                                <?php foreach($post_types as $var => $post_type): ?>
                                    <option <?php if ($set_post_type == $var) { ?> selected <?php } ?> value="<?php echo $var; ?>">
                                        <?php echo $post_type; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="select__arrow"></div>
                        </div>
                        </div>
                        <div class="columns four">
                            <div class="select">
                            <select name="topic">
                                <option selected value="">
                                    <?php _e('All Topics', 'streetleverage-tools') ?>
                                </option><?php foreach( $topics as $topic ): ?>
                                <option <?php if ($set_topic == $topic->term_id) { ?> selected <?php } ?>value="<?php echo $topic->term_id; ?>">
                                    <?php echo $topic->name; ?>
                                    </option><?php endforeach; ?>
                            </select>
                            <div class="select__arrow"></div>
                            </div>
                        </div>
                    </div>
                        <div class="row search-btn-holder">
                            <div class="twelve columns">
                                <input class="searchbtn button orange lrg" type="submit" value="<?php _e('Search', 'streetleverage-tools'); ?>">
                            </div>
                        </div>
            </form>
        </div>
    </div>
<?php endif; ?>