<?php
global $post;
if ($post->post_type == "events") {
$multi = get_field("multi-day-toggle", $post->ID);
$start_date = get_field("start-date", $post->ID);
$end_date = get_field("end-date", $post->ID);
$start_time = get_field("start-time", $post->ID);
$end_time = get_field("end-time", $post->ID);
$ceu = get_field("ceu", $post->ID);
$registration_url = get_field("registration-url", $post->ID);
$event_site_url = get_field("event-site-url", $post->ID);
?>
<div class="sl-event-details">
	<div class="holder row">
    <div class="sl-event-dates"><?php echo $start_date; if ($multi) { echo " &mdash; ".$end_date; } ?></div>
    <?php if ($start_time) { ?>
        <div class="sl-event-times"><?php echo $start_time; if ($end_time) { echo " &mdash; ".$end_time; } ?></div>
    <?php } 
    if ($ceu) { ?>
        <div class="sl-event-ceu">CEU: <?php echo $ceu; ?></div>
    <?php } ?>
	</div>
	<div class="holder row">
    <div class="sl-reg-link"><a href="<?php echo $registration_url; ?>" target="_blank" class="red button-large"><?php _e( 'Register Now', 'streetleverage-tools' ); ?></a></div>
    <div class="sl-site-link"><a href="<?php echo $event_site_url; ?>" target="_blank" class="red button-large">More Details</a></div>
	</div>
</div>
<?php } ?>