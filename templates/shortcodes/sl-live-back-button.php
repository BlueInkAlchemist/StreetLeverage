<?php

if( isset( $_SERVER['HTTP_REFERER'] ) ) {
    $value = $_SERVER['HTTP_REFERER'];
} else {
    $value = '';
}

//echo $value;
if (strpos($value, 'live.beta.streetleverage.com') !== false) : ?>
    <div class="back-button">
        <a href="<?php echo $value; ?>"><i class="fa fa-long-arrow-left" aria-hidden="true"> back to StreetLeverage &mdash; Live</i></a>
    </div>
<?php endif; ?>
