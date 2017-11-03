<?php
echo 'filtering...';
$content = apply_filters( 'wpa_content_filter', the_content() );
?>