<?php
/*------------------------------------*\
    SCHEDULE
\*------------------------------------*/



function create_schedules()
{
    register_post_type('schedule', // Register Custom Post Type (au singulier)
        array(
        'labels' => array(
            'name' => 'Journées', // Rename these to suit
            'singular_name' => 'Journée',
            'add_new' => 'Nouvelle journée',
            'add_new_item' => 'Ajouter une journée',
            'edit' => 'Modifier',
            'edit_item' => 'Modifier la journée',
            'new_item' => 'Nouvelle journée',
            'view' => 'Voir',
            'view_item' => 'Voir la journée',
            'search_items' => 'Chercher une journée',
            'not_found' => 'Aucune journée trouvée',
            'not_found_in_trash' => 'Aucune journée trouvée dans la corbeille'
        ),
        'public' => true,
        'hierarchical' => false, 
        'has_archive' => false,
        'supports' => array(
            'title',
            'editor'
        ),
        'can_export' => true,
        'rewrite' => array( 'slug' => 'horaire'),
    ));


    if( function_exists('register_field_group') ):

        register_field_group(array (
            'key' => 'group_548f7da8d77b6',
            'title' => 'Horaire',
            'fields' => array (
                array (
                    'key' => 'field_548f7e08c5b08',
                    'label' => 'Date',
                    'name' => 'date',
                    'prefix' => '',
                    'type' => 'date_picker',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'display_format' => 'd/m/Y',
                    'return_format' => 'd/m/Y',
                    'first_day' => 1,
                ),
                array (
                    'key' => 'field_548f7daec5b07',
                    'label' => 'Plages horaire',
                    'name' => 'time_frames',
                    'prefix' => '',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'min' => '',
                    'max' => '',
                    'layout' => 'row',
                    'button_label' => 'Ajouter une plage horaire',
                    'sub_fields' => array (
                        array (
                            'key' => 'field_548f813c602ee',
                            'label' => 'Plage horaire',
                            'name' => 'frame',
                            'prefix' => '',
                            'type' => 'repeater',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'min' => 1,
                            'max' => 1,
                            'layout' => 'table',
                            'button_label' => '',
                            'sub_fields' => array (
                                array (
                                    'key' => 'field_548f8152602ef',
                                    'label' => 'Début',
                                    'name' => 'start',
                                    'prefix' => '',
                                    'type' => 'date_time_picker',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array (
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'show_date' => 'false',
                                    'date_format' => 'm/d/y',
                                    'time_format' => 'h:mm',
                                    'show_week_number' => 'false',
                                    'picker' => 'select',
                                    'save_as_timestamp' => 'true',
                                    'get_as_timestamp' => 'true',
                                ),
                                array (
                                    'key' => 'field_548f81a4602f0',
                                    'label' => 'Fin',
                                    'name' => 'end',
                                    'prefix' => '',
                                    'type' => 'date_time_picker',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array (
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'show_date' => 'false',
                                    'date_format' => 'm/d/y',
                                    'time_format' => 'h:mm',
                                    'show_week_number' => 'false',
                                    'picker' => 'select',
                                    'save_as_timestamp' => 'true',
                                    'get_as_timestamp' => 'true',
                                ),
                                array (
                                    'key' => 'field_548f81c3602f1',
                                    'label' => 'Fermer cette plage',
                                    'name' => 'active',
                                    'prefix' => '',
                                    'type' => 'repeater',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array (
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'min' => 1,
                                    'max' => 1,
                                    'layout' => 'row',
                                    'button_label' => '',
                                    'sub_fields' => array (
                                        array (
                                            'key' => 'field_548f8bc98b553',
                                            'label' => 'Pause',
                                            'name' => 'disabled',
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
                                        array (
                                            'key' => 'field_548f8bef8b554',
                                            'label' => 'Libellé',
                                            'name' => 'label',
                                            'prefix' => '',
                                            'type' => 'text',
                                            'instructions' => '',
                                            'required' => 0,
                                            'conditional_logic' => array (
                                                array (
                                                    array (
                                                        'field' => 'field_548f8bc98b553',
                                                        'operator' => '==',
                                                        'value' => '1',
                                                    ),
                                                ),
                                            ),
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
                                            'readonly' => 0,
                                            'disabled' => 0,
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'schedule',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array (
                0 => 'the_content'
            ),
        ));

       

    endif;

} // END CREATE_SCHEDULES

function create_rooms()
{
    if( function_exists('register_field_group') ):

        register_post_type('room', // Register Custom Post Type (au singulier)
            array(
            'labels' => array(
                'name' => 'Salles', // Rename these to suit
                'singular_name' => 'Salle',
                'add_new' => 'Nouvelle salle',
                'add_new_item' => 'Ajouter une salle',
                'edit' => 'Modifier',
                'edit_item' => 'Modifier la salle',
                'new_item' => 'Nouvelle salle',
                'view' => 'Voir',
                'view_item' => 'Voir la salle',
                'search_items' => 'Chercher une salle',
                'not_found' => 'Aucune salle trouvée',
                'not_found_in_trash' => 'Aucune salle trouvée dans la corbeille'
            ),
            'public' => true,
            'hierarchical' => false, 
            'has_archive' => false,
            'supports' => array(
                'title',
                'editor'
            ),
            'can_export' => true,
            'rewrite' => array( 'slug' => 'salle'),
        ));

        register_field_group(array (
            'key' => 'group_548f8515ebd20',
            'title' => 'Salle',
            'fields' => array (
                array (
                    'key' => 'field_548f857695c5a',
                    'label' => 'Thématique',
                    'name' => 'theme',
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
                    'readonly' => 0,
                    'disabled' => 0,
                ),
                array (
                    'key' => 'field_548f858995c5b',
                    'label' => 'Couleur',
                    'name' => 'color',
                    'prefix' => '',
                    'type' => 'color_picker',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                ),
                array (
                    'key' => 'field_548f85a995c5c',
                    'label' => 'Colonne occupée dans la grille horaire',
                    'name' => 'column',
                    'prefix' => '',
                    'type' => 'select',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => array (
                        0 => 'Désactivé (toutes les colonnes)',
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => 'Toutes les colonnes',
                    ),
                    'default_value' => array (
                    ),
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 0,
                    'ajax' => 0,
                    'placeholder' => '',
                    'disabled' => 0,
                    'readonly' => 0,
                ),
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'room',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array (
                0 => 'the_content'
            ),  
        ));
    endif;
} // END CREATE_ROOMS


function create_conferences()
{
    register_post_type('session', // Register Custom Post Type (au singulier)
        array(
        'labels' => array(
            'name' => 'Conférences', // Rename these to suit
            'singular_name' => 'conférence',
            'add_new' => 'Nouvelle conférence',
            'add_new_item' => 'Ajouter une conférence',
            'edit' => 'Modifier',
            'edit_item' => 'Modifier la conférence',
            'new_item' => 'Nouvelle conférence',
            'view' => 'Voir',
            'view_item' => 'Voir la conférence',
            'search_items' => 'Chercher une conférence',
            'not_found' => 'Aucune conférence trouvée',
            'not_found_in_trash' => 'Aucune conférence trouvée dans la corbeille'
        ),
        'public' => true,
        'hierarchical' => false, 
        'has_archive' => false,
        'supports' => array(
            'title',
            'editor'
        ),
        'can_export' => true,
        'rewrite' => array( 'slug' => 'conference'),
    ));


    

    if( function_exists('register_field_group') ):

        register_field_group(array (
            'key' => 'group_548f3c4572b1c',
            'title' => 'Conférencier',
            'fields' => array (
                array (
                    'key' => 'field_548f3c4f12ac9',
                    'label' => 'À propos',
                    'name' => 'about',
                    'prefix' => '',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'min' => 1,
                    'max' => 1,
                    'layout' => 'table',
                    'button_label' => '',
                    'sub_fields' => array (
                        array (
                            'key' => 'field_548f3cc112acc',
                            'label' => 'Information sur le conférencier',
                            'name' => 'left',
                            'prefix' => '',
                            'type' => 'repeater',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'min' => 1,
                            'max' => 1,
                            'layout' => 'row',
                            'button_label' => '',
                            'sub_fields' => array (
                                array (
                                    'key' => 'field_548f3ce712acd',
                                    'label' => 'Photo',
                                    'name' => 'image',
                                    'prefix' => '',
                                    'type' => 'image',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array (
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'return_format' => 'array',
                                    'preview_size' => 'thumbnail',
                                    'library' => 'all',
                                ),
                                array (
                                    'key' => 'field_548f3cf312ace',
                                    'label' => 'Nom',
                                    'name' => 'name',
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
                                    'readonly' => 0,
                                    'disabled' => 0,
                                ),
                                array (
                                    'key' => 'field_548f3d0312acf',
                                    'label' => 'Réseaux sociaux',
                                    'name' => 'social',
                                    'prefix' => '',
                                    'type' => 'repeater',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array (
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'min' => '',
                                    'max' => '',
                                    'layout' => 'table',
                                    'button_label' => 'Ajouter un élément',
                                    'sub_fields' => array (
                                        array (
                                            'key' => 'field_548f3d1712ad0',
                                            'label' => 'Libellé',
                                            'name' => 'label',
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
                                            'readonly' => 0,
                                            'disabled' => 0,
                                        ),
                                        array (
                                            'key' => 'field_548f3d2f12ad1',
                                            'label' => 'Adresse web',
                                            'name' => 'url',
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
                                            'readonly' => 0,
                                            'disabled' => 0,
                                        ),
                                        array (
                                            'key' => 'field_548f3d3c12ad2',
                                            'label' => 'Réseau',
                                            'name' => 'provider',
                                            'prefix' => '',
                                            'type' => 'select',
                                            'instructions' => '',
                                            'required' => 0,
                                            'conditional_logic' => 0,
                                            'wrapper' => array (
                                                'width' => '',
                                                'class' => '',
                                                'id' => '',
                                            ),
                                            'choices' => array (
                                                'facebook' => 'Facebook',
                                                'twitter' => 'Twitter',
                                                'linkedin' => 'Linkedin',
                                                'instagram' => 'Instagram',
                                                'website' => 'Website',
                                            ),
                                            'default_value' => array (
                                            ),
                                            'allow_null' => 0,
                                            'multiple' => 0,
                                            'ui' => 0,
                                            'ajax' => 0,
                                            'placeholder' => '',
                                            'disabled' => 0,
                                            'readonly' => 0,
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        array (
                            'key' => 'field_548f3d8212ad3',
                            'label' => 'Bio',
                            'name' => 'right',
                            'prefix' => '',
                            'type' => 'wysiwyg',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'tabs' => 'all',
                            'toolbar' => 'full',
                            'media_upload' => 0,
                        ),
                    ),
                ),
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'session',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
        ));


        //
        //
        // CONDITIONNAL FIELDS
        
        $days = array();
        $timeframes = array();
        $feild_key = hexdec('548f9681431db');

        $schedules = new WP_Query( array(
                'post_type' => 'schedule',
            )
        );
        

        if($schedules->have_posts()){ while($schedules->have_posts()){

            $schedules->the_post();
            $feild_key++;
            array_push( $days, array(
                    'ID' => get_the_ID(),
                    'title' => get_the_title(),
                    'timeframes' => get_field('time_frames'),
                    'key' => dechex($feild_key)
                )
            );
        }}

        // get choices;
        $choices = array();
        foreach($days as $day){
            $choices[$day['ID']] = $day['title'];
        }

        $subfields = array (
            array (
                'key' => 'field_548f9681431db',
                'label' => 'Journée',
                'name' => 'day',
                'prefix' => '',
                'type' => 'radio',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => $choices,
                'other_choice' => 0,
                'save_other_choice' => 0,
                'default_value' => '',
                'layout' => 'vertical',
            )
        );

        // append subfields
        foreach($days as $day){
        
            $choices = array();
            $i = 0;
            if(has($day['timeframes'])){
                foreach($day['timeframes'] as $timeframe){
                    $frame = $timeframe['frame'][0];
                    if(!$frame['active'][0]['disabled']){
                        $choices[$i] = 'De '. strftime('%H:%M', $frame['start']).' à '.strftime('%H:%M', $frame['end']) ; 
                    }
                    $i++;
                }
            }
            
            array_push($subfields,
                array (
                    'key' => 'field_'. $day['key'],
                    'label' => 'Plage horaire',
                    'name' => 'frame_'. $day['ID'],
                    'prefix' => '',
                    'type' => 'select',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array (
                        array (
                            array (
                                'field' => 'field_548f9681431db',
                                'operator' => '==',
                                'value' => $day['ID'],
                            ),
                        ),
                    ),
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => $choices,
                    'default_value' => array (
                    ),
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 0,
                    'ajax' => 0,
                    'placeholder' => '',
                    'disabled' => 0,
                    'readonly' => 0,
                )
            );
        }

        // REGISTER THE GENERATED FIELD
        register_field_group(array (
            'key' => 'group_548f95ddc3d58',
            'title' => 'Sélectionner une plage horaire',
            'fields' => array (
                array (
                    'key' => 'field_548f95e8431da',
                    'label' => 'Sélectionner',
                    'name' => 'select_time_frame',
                    'prefix' => '',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'min' => 1,
                    'max' => 1,
                    'layout' => 'block',
                    'button_label' => '',
                    'sub_fields' => $subfields
                ),
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'session',
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

} // END CREATE_CONFERENCERS

add_action('init', 'create_schedules');
add_action('init', 'create_rooms');
add_action('init', 'create_conferences');

?>