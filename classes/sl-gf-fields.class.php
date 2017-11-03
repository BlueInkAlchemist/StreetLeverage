<?php

class SL_GF_Fields
{
    protected static $instance = null;

    private $fetched_ids;

    private function __construct() {

        $this->fetched_ids = array();

        // Hooks for our user reg Gravityform 
        add_filter( 'gform_pre_render_2', array($this, 'generate_posts' ) ); 
        add_filter( 'gform_pre_validation_2', array($this, 'generate_posts' ) );
        add_filter( 'gform_pre_submission_filter_2', array($this, 'generate_posts' ) );
        add_filter( 'gform_admin_pre_render_2', array($this, 'generate_posts' ) );
        add_filter( 'gform_pre_render_6', array($this, 'generate_posts' ) ); 
        add_filter( 'gform_pre_validation_6', array($this, 'generate_posts' ) );
        add_filter( 'gform_pre_submission_filter_6', array($this, 'generate_posts' ) );
        add_filter( 'gform_admin_pre_render_6', array($this, 'generate_posts' ) );
        add_filter( 'gform_pre_render_8', array($this, 'generate_posts' ) ); 
        add_filter( 'gform_pre_validation_8', array($this, 'generate_posts' ) );
        add_filter( 'gform_pre_submission_filter_8', array($this, 'generate_posts' ) );
        add_filter( 'gform_admin_pre_render_8', array($this, 'generate_posts' ) );
        add_filter( 'gform_field_choice_markup_pre_render_2_25', array($this, 'append_markup') );
        add_filter( 'gform_field_choice_markup_pre_render_6_25', array($this, 'append_markup') );
        add_filter( 'gform_field_choice_markup_pre_render_8_1', array($this, 'append_markup') );
        add_action( 'gform_after_submission_6', array($this, 'set_post_content'));
        add_action( 'gform_after_submission_8', array($this, 'set_post_content'));
        add_action( 'wp_enqueue_scripts', array($this, 'sl_enqueue_reg_scripts' ));

    } 

    public static function get_instance() {
        if(null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    function sl_enqueue_reg_scripts() {
        echo "am I here?";
        wp_enqueue_script( 'sl_reg_scripts', WP_PLUGIN_DIR . "/streetleverage-tools/js/sl-reg-scripts.js", false );
    }

    // Turbines to power

    public function generate_posts ( $form ) {

        // Query for parent categories 
        
        $cats = get_categories( array(
            'orderby' => 'name',
            'parent'  => 0,
            'hide_empty' => false
        ) );
        
        // Start with an empty array for our choices 
        $new_choices = array( /*
            array(
                'text'       => 'Test Item',
                'value'      => '0',
                'isSelected' => false
            ) */
        );
            // Our foreach loop 
            $i=1;
            foreach ($cats as $cat) :  

                    $descendant= get_term_children( $cat->term_id, $cat->taxonomy );
                    
                    if ( !empty($descendant)) :
                        // Generate new checkboxes 
                       
                        array_push($new_choices, array(
                                'text'       => $cat->name,
                                'value'      => $cat->term_id,
                                'isSelected' => false
                            )
                        );

                        //Get Subcategories
                        // $descendant= array('child_of'=>$cat->term_id);
                        
                        $kittens = get_categories( array(
                            'orderby' => 'name',
                            'parent' => $cat->term_id,
                            'hide_empty' => false
                        ) );
                        
                        $j=1;
                        foreach($kittens as $kitten) :
                            // Add Subcategories to our choices 
                            array_push($new_choices, array(
                                'text'       => $kitten->name,
                                'value'      => $kitten->term_id,
                                'isSelected' => false
                            )
                        );
                            // Guess what we do now!
                            
                        endforeach;
                        $j++;

                        
                        
                    $i++;   
                    endif;
                    
            endforeach;
            // var_dump($new_choices);
            // Now we populate it!
            foreach ( $form['fields'] as &$field ) {
                if ( $field->id == 25 ) {
                    $field->choices = $new_choices;
                } else if ( $field->id == 1 ) {
                    $field->choices = $new_choices;
                }
            }

        return $form;
    }

    public function append_markup ( $choice_markup, $choice, $field, $value ) {
        
        $id_start = strpos($choice_markup, "value='")+7;
        $id_len = strpos($choice_markup, "'", $id_start)-$id_start;
        $term_id = substr($choice_markup, $id_start, $id_len);
        $term = get_term($term_id, 'category');
        $descendants = get_term_children($term_id, 'category');
        $classes = "sl_topic sl_topic_" . $term_id . " ";

        $label_start = strpos($choice_markup, "<label");
        $label_len = strpos($choice_markup, ">", $label_start)-$label_start;
        $label_tag = substr($choice_markup, $label_start, $label_len+1);
        $choice_markup = substr_replace( $choice_markup, '', $label_start, $label_len+1);
        $choice_markup  = $label_tag . $choice_markup;

        $label_end_start = strpos($choice_markup, "</label>");
        $label_end_tag = substr($choice_markup, $label_end_start, 8);
        $choice_markup = substr_replace( $choice_markup, '', $label_end_start, 8 );
        $choice_markup  .= $label_end_tag;

        if( empty( $descendants ) ) {

            $parent_id = $term->parent;
            $classes .= "sl-hide sl_child_topic sl_childof_" . $parent_id . " ";

        } else {
            $classes .= "sl_parent_topic ";
        }

        //echo($term_id);
        //echo('<br/>');

        $choice_markup = str_replace( "<li class='", "<li class='" . $classes, $choice_markup );
        return $choice_markup;
    }

    public function set_post_content( $entry, $form ) {

        echo('<script>console.log("fields should update here");</script>');
        foreach ( $form['fields'] as $field ) {
            $field_value = $field->get_value_export( $entry, $field->id, true );
            // do something with the field value.
        }

    }

}


?>