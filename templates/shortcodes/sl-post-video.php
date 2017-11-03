<?php

global $post;

$video_code = null;

if( get_post_meta( get_the_ID(), 'video_embed' ) ) {
    $video_code = reset(get_post_meta( get_the_ID(), 'video_embed' ));
}

?>

<?php if($video_code): ?>

    <div class="sl-post-video video-container">

        <?php echo $video_code; ?>

    </div>

<?php endif; ?>
