<?php
/*------------------------------------*\
    SCHEDULE
\*------------------------------------*/

function create_conferencers()
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
        'rewrite' => array( 'slug' => 'session'),
    ));
}

function create_schedules()
{
    register_post_type('schedule', // Register Custom Post Type (au singulier)
        array(
        'labels' => array(
            'name' => 'Horaire', // Rename these to suit
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
        'rewrite' => array( 'slug' => 'schedules'),
    ));
}

add_action('init', 'create_schedules');
add_action('init', 'create_conferencers');



?>