<?php
$args = array(
    'post_status' => 'publish',
    'post_type' => 'benefactor',
    'meta_query' => array(
        array(
            'key' => 'benefactor-active',
            'compare' => '==',
            'value' => '1',
        )
    )
);

$benefactor_query = new WP_Query( $args );

?>

<?php if( $benefactor_query->have_posts() ): ?>

    <div class="sl-benefactor-section">

        <h4 class="sl-benefactor-bar-title sl-title"><?php _e( 'Companies committed to resourcing interpreters', 'streetleverage-tools' ); ?></h4>

        <?php while( $benefactor_query->have_posts() ): ?>

            <?php $benefactor_query->the_post(); ?>

            <div class="sl-benefactor">
                <a href="<?php echo get_field('link-to-benefactor'); ?>" class="sl-benefactor-link">
                    <img src="<?php echo get_the_post_thumbnail_url( $trending_post->ID ); ?>" />
                </a>
            </div>

        <?php endwhile; ?>

    </div>


<?php endif; ?>
