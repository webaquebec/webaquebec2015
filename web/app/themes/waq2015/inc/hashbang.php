<?php
/*------------------------------------*\
    HASHBANG
\*------------------------------------*/

if( function_exists('register_field_group') ):

register_field_group(array (
    'key' => 'group_548a153b67093',
    'title' => 'Hashbang',
    'fields' => array (
        array (
            'key' => 'field_548a1541c09c2',
            'label' => 'Hashbang vers l\'accueil',
            'name' => 'bang',
            'prefix' => '',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'message' => '',
            'default_value' => 0,
        ),
    ),
    'location' => array (
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
            ),
            array (
                'param' => 'page_template',
                'operator' => '!=',
                'value' => 'template-home.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
));

endif;
?>