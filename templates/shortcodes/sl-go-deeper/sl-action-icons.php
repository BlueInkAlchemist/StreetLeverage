<?php
global $post;
$correction_url = '/corrections/?post_id=' . $post->ID . '&post_title=' . urlencode(get_the_title($post->ID));

?>

<div class="sl-action-icons-wrapper">
	<div class="sl-like-button sl-button-wrapper"><?php 
		SL_Helper::the_like_button($post->ID);
	?></div>
	<div class="sl-correction-button sl-button-wrapper"><a href="<?php echo $correction_url; ?>" target="_blank"><i class="fa fa-pencil" aria-hidden="true"></i></a></div>
	<div class="sl-share-button sl-button-wrapper"><a href="#" onclick="sl_share_popup_show();"><i class="fa fa-share-alt" aria-hidden="true"></i></a></div>
	<?php //echo do_shortcode('[easy-social-share-popup counters=0 style="button"]'); ?>
</div>
