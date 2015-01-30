<?php
/*------------------------------------*\
    SCHEDULE - UPDATE FAVORITES
\*------------------------------------*/

// COMPOSER REQUIRE
// composer require wpackagist-plugin/acf-range-field:dev-trunk
// composer require wpackagist-plugin/acf-field-date-time-picker:dev-trunk
// composer require wpackagist-plugin/intuitive-custom-post-order:dev-trunk

//
// add and remove sessions from "favorites" acf field.
//
// INPUT format
// $_POST['add'] = [1,2,3]
// $_POST['remove'] = [1,2,3]
//
// OUTPUT format
// return 1|2|3|7|8|9

function update_favorites($user_id, $add, $remove){
    $favorites_str = get_field('favorites','user_'.$user_id);
    if(has($favorites_str))
        $favorites = explode('|', $favorites_str);
    else
        $favorites = [];
    $favorites = array_diff($favorites, $remove, $add);
    $favorites = array_merge($favorites, $add);
    sort($favorites);
    $favorites_str = implode('|', $favorites);
    update_field('favorites', $favorites_str, 'user_'.$user_id);
    return $favorites_str;
}

//
//
// CHECK IF SESSION ID IS IN FAVORITES
function session_is_favorite($session_id, $favorites_str){
    if(has($favorites_str))
        $favorites = explode('|', $favorites_str);
    else
        $favorites = [];
    return array_search($session_id, $favorites)>-1;
}


//
//
// USERS
function create_users()
{
    if( function_exists('register_field_group') ):
        register_field_group(array (
            'key' => 'group_54cb0036f3035',
            'title' => 'Mon horaire',
            'fields' => array (
                array (
                    'key' => 'field_54cb0053a3812',
                    'label' => 'IDs',
                    'name' => 'favorites',
                    'prefix' => '',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                    'readonly' => 1,
                    'disabled' => 0,
                ),
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'user_type',
                        'operator' => '==',
                        'value' => 'administrator',
                    ),
                    array (
                        'param' => 'user_role',
                        'operator' => '==',
                        'value' => 'all',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
        ));
    endif;
}

add_action('init', 'create_users');

?>