<?php

$gravity_html = do_shortcode( '[gravityform id="2" title="true" description="true"]' );

// Prepare the litter box

$litterbox = array();

// Cats & kittens loop

 $cats = get_categories( array(
            'orderby' => 'name',
            'parent'  => 0
        ) );



foreach ($cats as $cat) :  

        $cat_num = $cat->term_id;

        $descendant= get_term_children( $cat->term_id, $cat->taxonomy );
    

        if ( !empty($descendant)) :
            // The loop within the loop
            $kittens = get_categories( array(
                'orderby' => 'name',
                'parent' => $cat->term_id
            ) );

            foreach($kittens as $kitten) :
                
                $kitten_num = $kitten->term_id;

                // Put something in the litter box 
               $litterbox[$cat_num][] = $kitten_num;
            endforeach;

        endif;

endforeach;

// Load html into domdoc

$domDoc = new DOMDocument();
$domDoc->loadHTML( $gravity_html );

$xpath = new DomXPath($domDoc);

// Scoop the litter box

foreach ( $litterbox as $parent=>$topic ) :

    //$parent = $litter['parent-id'];
    echo '<script>console.log("Parent: '.$parent.'")</script>';
    //$topic = $litter['child-id'];
    echo '<script>console.log("Child: '.$topic.'")</script>';
    
    $nodes = $xpath->query("//input[@value='.$parent.'");
    echo '<script>console.log("'.$nodes.'")</script>';
    // Loopception
    
    foreach ( $nodes as $i => $node ) :
        
        echo '<script>console.log("Result '.$i.': '.$node->nodeValue.'")</script>';

    endforeach;

endforeach;

echo $gravity_html;

?>