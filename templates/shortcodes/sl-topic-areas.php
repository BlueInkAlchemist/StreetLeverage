<?php

$args = array(
    'taxonomy' => 'category',
    'parent' => 0,
    'hide_empty' => true,
);
$topics = get_terms( $args );
$i = 0;

?>

<div class="sl-topic-areas-section-wrapper">

    <h3 class="sl-title"><?php _e( 'Find additional goodness in these topic areas.', 'streetleverage-tools' ); ?></h3>
	<div class="row">
    <?php foreach( $topics as $topic ):

        $topic_title = $topic->name;
        $topic_thumb_url = get_field( 'topic_thumbnail', $topic )["sizes"]["medium"];

    ?>


        <div onclick="location.href='<?php get_term_link( $topic, "category" ); ?>'" class="sl-square three columns matchheight" style="cursor: pointer;background:rgba(0,0,0,0) url(<?php echo $topic_thumb_url ?>) no-repeat scroll center top / cover;">
            <span class="sl-border-hover"></span>
            <div class="sl-wrapper">
                <h5 class="sl-title"><?php echo $topic_title; ?></h5>
            </div>
            <div class="color-filter"></div>

        </div>

        <?php $i++; ?>
        <?php if($i%4 == 0): ?>
    </div>
    <div class="row">
        <?php endif; ?>


    <?php endforeach; ?>
	</div>
</div>
