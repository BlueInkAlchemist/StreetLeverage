<?php

global $post;

?>

<?php if(get_field('scenario-transcript')): ?>
    <div class="sl-podcast-shownotes">

        <h3 class="sl-section-title"><?php _e( "Scenario Transcript", "streetleverage-tools" ); ?></h3>

        <?php echo get_field('scenario-transcript'); ?>

    </div>
<?php endif; ?>
