<?php

   $show_content = get_field('show_content');

   if ($show_content) {
       echo '<div style="show_content">' . get_option( 'sl_trending_text_prompt' ) . '</div>';
   }
?>