<?php

global $post;

?>

<?php if(get_field('presentation-show-notes')): ?>
    <div class="sl-podcast-shownotes">

        <h4 class="sl-shownotes-header"><?php _e( "Presentation Notes", "streetleverage-tools" ); ?></h4>

        <?php echo get_field('presentation-show-notes'); ?>

    </div>
<?php endif; ?>