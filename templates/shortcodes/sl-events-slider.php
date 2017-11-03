<?php
$today = date('Ymd');
$args = array(
    'post_type' => 'events',
    'post_status' => 'publish',
    'numberposts' => 5,
    'meta_key' => 'start-date',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'start-date',
            'value' => $today,
            'compare' => '>='
        )
    ),
);
$upcoming_events = get_posts($args);
?>

<div class="sl-events-slider">

    <ul class="bxslider">

        <?php foreach( $upcoming_events as $upcoming_event ): ?>

        <li class="slide">
            <div style="background: url(<?php echo get_the_post_thumbnail_url( $upcoming_event->ID ); ?>); background-repeat: no-repeat; background-size: cover; background-position: top center; height: 100%;">
                <div class="sl-wrapper">
	                <h2 class="sl-event-title"><?php echo get_the_title( $upcoming_event->ID ); ?></h2>
					<span class="sl-event-excerpt"><?php echo SL_Helper::sl_get_the_excerpt( $upcoming_event->ID ) ?></span>
	                <div class="sl-event-date">
	                    <span class="sl-event-start-date"><?php echo get_field( 'start-date', $upcoming_event->ID ); ?></span>
	                    <?php if( get_field( 'end-date', $upcoming_event->ID ) ): ?>
	                        <span class="sl-event-date-separator"> - </span>
	                        <span class="sl-event-end-date"><?php echo get_field( 'end-date', $upcoming_event->ID ); ?></span>
	                    <?php endif; ?>
	                    <?php if( get_field( 'start-time', $upcoming_event->ID ) ): ?>
	                        <span class="sl-event-separator"> | </span>
	                        <span class="sl-event-start-time"><?php echo get_field( 'start-time', $upcoming_event->ID ); ?></span>
	                        <?php if( get_field( 'end-time', $upcoming_event->ID ) ): ?>
	                            <span class="sl-event-time-separator"> - </span>
	                            <span class="sl-event-end-time"><?php echo get_field( 'end-time', $upcoming_event->ID ); ?></span>
	                        <?php endif; ?>
	                    <?php endif; ?>
                        <?php if( get_field( 'ceu', $upcoming_event->ID ) ): ?>
                            <span class="sl-event-separator"> | </span>
                            <span class="sl-event-start-time"> CEU: <?php echo get_field( 'ceu', $upcoming_event->ID ); ?></span>
                        <?php endif; ?>
	                </div>
                <a href="<?php echo get_the_permalink($upcoming_event->ID); ?>" class="orange button"><?php _e( 'Register', 'streetleverage-tools' ); ?></a>
                </div>
                <div class="color-filter"></div>
            </div>
            
        </li>

        <?php endforeach; ?>

    </ul>

</div>


