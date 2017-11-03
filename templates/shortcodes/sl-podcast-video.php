<?php
global $post;

/*

$oembed_endpoint = 'http://vimeo.com/api/oembed';

$video_url = 'http://vimeo.com/' . get_field('podcast-video-id');

$xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_url) . '&width=640';

$curl = curl_init($xml_url);
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_TIMEOUT, 30);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
$curl_exec = curl_exec($curl);
curl_close($curl);

$oembed = simplexml_load_string($curl_exec);

*/


?>

<?php if( !empty( get_field( 'podcast-video-embed' ) ) ): ?>

    <div class="sl-podcast-video video-container">

        <?php echo html_entity_decode( get_field( 'podcast-video-embed' ) ); ?>

    </div>

<?php endif; ?>
