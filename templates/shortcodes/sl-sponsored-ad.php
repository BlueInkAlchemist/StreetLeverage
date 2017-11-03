<?php
global $post;
$ads = get_field( 'sponsored-advertisements' );
?>

<div class="sl-sponsored-ads-wrapper">
    <?php foreach ( $ads as $ad ) : ?>

        <div class="sl-sponsored-ad">

            <a href="<?php echo $ad["ad-link"]; ?>">
                <img src="<?php echo $ad["ad-image"]; ?>" />
            </a>
            <p class="sl-sponsored-ad-label">Sponsored Ad</p>
        </div>
        
    <?php endforeach; ?>
</div>
