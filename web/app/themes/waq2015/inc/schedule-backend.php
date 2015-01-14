<?php
/*------------------------------------*\
    SCHEDULE - BACK END
\*------------------------------------*/

// COMPOSER REQUIRE
// composer require wpackagist-plugin/acf-range-field:dev-trunk 
// composer require wpackagist-plugin/acf-field-date-time-picker:dev-trunk
// composer require wpackagist-plugin/intuitive-custom-post-order:dev-trunk



function create_grid(){

    if( function_exists('register_field_group') ):

        //
        //
        // Columns Quantity

        register_field_group(array (
          'key' => 'group_54998c622f91a',
          'title' => 'Grille horaire',
          'fields' => array (
            array (
              'key' => 'field_54998c85454ad',
              'label' => 'Nombre de colonnes',
              'name' => 'columns_qty',
              'prefix' => '',
              'type' => 'number',
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
              'min' => '0',
              'max' => '',
              'step' => '',
              'readonly' => 0,
              'disabled' => 0,
            ),
          ),
          'location' => array (
            array (
              array (
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'acf-options',
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


//
//
// Create schedules and timeframes

function create_schedules()
{
    register_post_type('grid', // Register Custom Post Type (au singulier)
        array(
        'labels' => array(
            'name' => 'Grilles horaire', // Rename these to suit
            'singular_name' => 'Grille',
            'add_new' => 'Nouvelle grille',
            'add_new_item' => 'Ajouter une grille',
            'edit' => 'Modifier',
            'edit_item' => 'Modifier la grille',
            'new_item' => 'Nouvelle grille',
            'view' => 'Voir',
            'view_item' => 'Voir la grille',
            'search_items' => 'Chercher une grille',
            'not_found' => 'Aucune grille trouvée',
            'not_found_in_trash' => 'Aucune grille trouvée dans la corbeille'
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

        //
        //
        // Time frames
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
                    'return_format' => 'd/m/y',
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
                                    'time_format' => 'H:mm',
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
                                    'time_format' => 'H:mm',
                                    'show_week_number' => 'false',
                                    'picker' => 'select',
                                    'save_as_timestamp' => 'true',
                                    'get_as_timestamp' => 'true',
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
                        'value' => 'grid',
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

} // END CREATE_GRIDS


//
//
// Create locations
function create_locations()
{
    if( function_exists('register_field_group') ):

        register_post_type('location', // Register Custom Post Type (au singulier)
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
        
        //
        //
        // location infos

        $cols_qty = get_field('columns_qty', 'options');
        if(!has($cols_qty)) $cols_qty = 0;

        register_field_group(array (
            'key' => 'group_549999947eb80',
            'title' => 'Salle',
            'fields' => array (
                array (
                    'key' => 'field_5499999a2605e',
                    'label' => 'Informations sur la salle',
                    'name' => 'infos',
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
                            'key' => 'field_54999a0c2605f',
                            'label' => 'Libellés',
                            'name' => 'labels',
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
                                    'key' => 'field_54999a3426060',
                                    'label' => 'Titre alternatif',
                                    'name' => 'alt',
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
                                    'key' => 'field_54999a4226061',
                                    'label' => 'Sous-titre',
                                    'name' => 'subtitle',
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
                                    'key' => 'field_54999a6126062',
                                    'label' => 'Cacher les libellés',
                                    'name' => 'hide',
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
                        ),
                        array (
                            'key' => 'field_54999a8126063',
                            'label' => 'Paramètres',
                            'name' => 'settings',
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
                                    'key' => 'field_54999ac326064',
                                    'label' => 'Classe CSS',
                                    'name' => 'class',
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
                                    'key' => 'field_54999ad426065',
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
                                    'key' => 'field_54999aeb26066',
                                    'label' => 'Colonnes ocuppées dans la grille',
                                    'name' => 'range',
                                    'prefix' => '',
                                    'type' => 'Range',
                                    'instructions' => ($cols_qty==0 ? 'Vous devez augmenter le nombre de colonnes dans l\'onglet OPTIONS et enregistrer vos modifications' : ''),
                                      'required' => 0,
                                      'conditional_logic' => 0,
                                      'wrapper' => array (
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                      ),
                                      'slider_type' => 'range',
                                      'title' => '',
                                      'prepend' => '',
                                      'append' => '',
                                      'separate' => '-',
                                      'default_value_1' => ($cols_qty==0 ? 0 : 1),
                                      'default_value_2' => ($cols_qty==0 ? 0 : 1),
                                      'min' => ($cols_qty==0 ? 0 : 1),
                                      'max' => $cols_qty,
                                      'step' => 1,
                                    'font_size' => 14,
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
                        'value' => 'location',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array (
                0 => 'the_content',
            ),
        ));
   
    endif;
} // END CREATE_locationS

function create_sessions()
{
    register_post_type('session', // Register Custom Post Type (au singulier)
        array(
        'labels' => array(
            'name' => 'Activités', // Rename these to suit
            'singular_name' => 'Activité',
            'add_new' => 'Nouvelle activité',
            'add_new_item' => 'Ajouter une activité',
            'edit' => 'Modifier',
            'edit_item' => 'Modifier l\'activité',
            'new_item' => 'Nouvelle activité',
            'view' => 'Voir',
            'view_item' => 'Voir l\'activité',
            'search_items' => 'Chercher une activité',
            'not_found' => 'Aucune activité trouvée',
            'not_found_in_trash' => 'Aucune activité trouvée dans la corbeille'
        ),
        'public' => true,
        'hierarchical' => false, 
        'has_archive' => false,
        'supports' => array(
            'title',
            'editor'
        ),
        'can_export' => true,
        'rewrite' => array( 'slug' => 'activite'),
    ));


    register_taxonomy( 'theme', 'session', array(
            'labels'                => array(
                'name'                       => 'Thématiques',
                'singular_name'              => 'Thématique',
                'search_items'               => 'Chercher une thématique',
                'popular_items'              => 'Thématiques populaires',
                'all_items'                  => 'Toutes les thématiques',
                'parent_item'                => null,
                'parent_item_colon'          => null,
                'edit_item'                  => 'Modifier la thématique',
                'update_item'                => 'Mettre a jour la thématique',
                'add_new_item'               => 'Ajouter une thématique',
                'new_item_name'              => 'Nouvelle thématique',
                'separate_items_with_commas' => 'Séparer les thématiques par des virgules',
                'add_or_remove_items'        => 'Ajouter ou retirer une thématique',
                'choose_from_most_used'      => 'Choisir parmi les plus utilisées',
                'not_found'                  => 'Aucune thématique trouvée',
                'menu_name'                  => 'Thématiques',
            ),
            'hierarchical'          => false,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite'               => array( 'slug' => 'theme' )
        )
    );

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
                            'name' => 'infos',
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
                                    'key' => 'field_548f3cf312ad4',
                                    'label' => 'Titre',
                                    'name' => 'job',
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
                            'name' => 'bio',
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
        // EXCERPT
        register_field_group(array (
            'key' => 'group_54a997c45720e',
            'title' => 'Réglages',
            'fields' => array (
                array (
                    'key' => 'field_54ab06b4f8dc9',
                    'label' => 'Lien vers la fiche d\'activité',
                    'name' => 'link_to_post',
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
                    'key' => 'field_54a997dc2b0ff',
                    'label' => 'Résumé de l\'activité',
                    'name' => 'excerpt',
                    'prefix' => '',
                    'type' => 'textarea',
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
                    'maxlength' => '',
                    'rows' => '',
                    'new_lines' => 'wpautop',
                    'readonly' => 0,
                    'disabled' => 0,
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

        //
        //
        // CONDITIONNAL FIELDS
        
        $grids = array();
        $timeframes = array();
        $feild_key = hexdec('548f9681431db');

        $schedules = new WP_Query( array(
                'post_type' => 'grid',
            )
        );
        

        if($schedules->have_posts()){ 
            foreach($schedules->posts as $grid){

            $schedules->the_post();
            $feild_key++;
            array_push( $grids, array(
                    'ID' => $grid->ID,
                    'title' => get_the_title($grid->ID),
                    'timeframes' => get_field('time_frames', $grid->ID),
                    'key' => dechex($feild_key)
                )
            );

        }}

        // get choices
        $choices = array();
        foreach($grids as $grid){
            $choices[$grid['ID']] = $grid['title'];
        }

        $fields = array (
            array (
                'key' => 'field_548f9681431db',
                'label' => 'Grille',
                'name' => 'grid',
                'prefix' => '',
                'type' => 'radio',
                'instructions' => '',
                'required' => 1,
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

        // append fields
        foreach($grids as $grid){
    
            $choices = array();
            $i = 0;
            if(has($grid['timeframes'])){
                foreach($grid['timeframes'] as $timeframe){
                    $frame = $timeframe['frame'][0];
                    $start = has($frame['start']) ? strftime('%H:%M', $frame['start']) : '...';
                    $end = has($frame['end']) ? strftime('%H:%M', $frame['end']) : '...';
                    $choices[$i] = 'De '. $start .' à '. $end ; 
                    $i++;
                }
            }
            
            array_push($fields,
                array (
                    'key' => 'field_'. $grid['key'],
                    'label' => 'Plage horaire',
                    'name' => 'frame_'. $grid['ID'],
                    'prefix' => '',
                    'type' => 'select',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => array (
                        array (
                            array (
                                'field' => 'field_548f9681431db',
                                'operator' => '==',
                                'value' => $grid['ID'],
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
            
            // add_filter('acf/load_value/name=frame_'. $grid['ID'], 'append_count_to_timeframes', 10, 3);
        
        }

        //
        // append location field
        array_push($fields,
            array (
              'key' => 'field_5491f516562e5',
              'label' => 'Salle',
              'name' => 'location',
              'prefix' => '',
              'type' => 'post_object',
              'instructions' => '',
              'required' => 1,
              'conditional_logic' => 0,
              'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
              ),
              'post_type' => array (
                0 => 'location',
              ),
              'taxonomy' => '',
              'allow_null' => 0,
              'multiple' => 0,
              'return_format' => 'ID',
              'ui' => 1,
            )
        );

        //
        // REGISTER THE GENERATED FIELD GROUP
        register_field_group(array (
            'key' => 'group_548f95ddc3d58',
            'title' => 'Sélectionner une plage horaire',
            'fields' => $fields,
            'location' => array (
                array (
                    array (
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'session',
                    ),
                ),
            ),
            'menu_order' => -1,
            'position' => 'side',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
        ));

    endif;

} // END CREATE_CONFERENCERS



//
//
// ADMIN SESISONS LIST COLUMNS
function set_session_columns($columns) {
    unset( $columns['date'] );
    unset( $columns['taxonomy-theme'] );
    $columns['grid'] = 'Grille';
    $columns['timeframe'] = 'Plage horaire';
    $columns['location'] = 'Salle';
    $columns['taxonomy-theme'] = 'Thématique';

    return $columns;
}
function set_session_sortable_columns($columns) {

    $columns['grid'] = 'grid';
    $columns['location'] = 'location';

    return $columns;
}

function print_session_column( $column, $post_ID ) {
    $grid_ID = get_field('grid',$post_ID);
    $frame_ID = get_field('frame_'.$grid_ID, $post_ID);
    $timeframes = get_field('time_frames', $grid_ID);
    $frame = array(
            'start' => $timeframes[$frame_ID]['frame'][0]['start'],
            'end' => $timeframes[$frame_ID]['frame'][0]['end']
        );
    $start = has($frame['start']) ? strftime('%H:%M', $frame['start']) : '...';
    $end = has($frame['end']) ? strftime('%H:%M', $frame['end']) : '...';

    $location_ID = get_field('location',$post_ID);
    switch ( $column ) {

        case 'grid':
            echo get_the_title($grid_ID);
            break;

        case 'timeframe':
            echo 'De '. $start .' à '. $end ;
            break;

        case 'location':
            
            echo get_the_title($location_ID);
            break;

    }
}

function grid_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'grid' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'day',
            'orderby' => 'meta_value'
        ) );
    }
    return $vars;
}

function location_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'location' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'location',
            'orderby' => 'meta_value'
        ) );
    }
    return $vars;
}

    
add_action('init', 'create_grid');
add_action('init', 'create_schedules');
add_action('init', 'create_locations');
add_action('init', 'create_sessions');

add_filter( 'manage_edit-session_columns', 'set_session_columns' );
add_filter( 'manage_edit-session_sortable_columns', 'set_session_sortable_columns' );
add_action( 'manage_session_posts_custom_column' , 'print_session_column', 10, 2 );
add_filter( 'request', 'grid_column_orderby' );
add_filter( 'request', 'location_column_orderby' );


// 

?>