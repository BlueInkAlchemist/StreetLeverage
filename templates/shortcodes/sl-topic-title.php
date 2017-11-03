<?php
global $wp_query;
$topic = $wp_query->get_queried_object();
if (!$topic->name) {
    $page_topic = $_GET["topic"];
    $page_type = $_GET["type"];
    $page_title = "All ";
    if ($page_type != "") {
        $page_title .= $page_type;
        if ($page_title == "All scenarios") {
            $page_title = "All Reflection Room Scenarios";
        } else if ($page_title == "All podcasts") {
            $page_title = "All Behind the Practice Episodes";
        } else if ($page_title == "All more_resources") {
            $page_title = "More Resources";
        } else if ( $page_title == "All live_presentations" ) {
            $page_title = "All Past LIVE Presentations";
        } else if ( $page_title == "All collections" ) {
            if ( $_GET["order"] == "DESC" ) {
                $page_title = "Featured Collections";
            }
        }
    } else if ($page_topic != "") {
        $term = get_term( (int)$page_topic );
        $page_title .= $term->name;
        $page_title .= " Articles";
    }
} else {
    $page_title = $topic->name;
}
if ( $page_title == "All " ) {
    $page_title = "Recent Posts";
}
// change						
?>

<div class="sl-topic-title">
    <h1 class="sl-title"><?php echo $page_title; ?></h1>
    <!--<div class="sl-excerpt"><?php //echo $topic->description; ?></div>-->
    <?php 
        if($topic->parent != 0) {
            $subtopic = get_term_by('id', $topic->parent, 'category'); ?>

           <div class="sl-subtopic">Part of the <a href="<?php echo get_term_link($subtopic) ?>" class="sl-subtopic-link"><?php echo $subtopic->name; ?></a> category.</div>
    <?php
        };
    
    ?>

</div>
