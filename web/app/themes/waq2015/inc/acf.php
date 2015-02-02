<?php
/*------------------------------------*\
    CUSTOM FIELDS
\*------------------------------------*/


if( function_exists('register_field_group') ):

  //
  //
  // BLOG POST FEATURED IMAGE
  register_field_group(array (
    'key' => 'group_54cf82601847f',
    'title' => 'Featured',
    'fields' => array (
      array (
        'key' => 'field_54cf8264754a6',
        'label' => 'Featured image',
        'name' => 'featured',
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
        'preview_size' => 'blog-thumb',
        'library' => 'all',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'post',
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
  // PROFILES
  register_field_group(array (
    'key' => 'group_54cf8e1aa6d64',
    'title' => 'Profile',
    'fields' => array (
      array (
        'key' => 'field_54cf8e2e46cd8',
        'label' => 'Informations complémentaires',
        'name' => 'profile_infos',
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
            'key' => 'field_54cf8ff1e641e',
            'label' => 'Image',
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
            'preview_size' => 'medium',
            'library' => 'all',
          ),
          array (
           'key' => 'field_54cf8fffe641f',
            'label' => 'Biographie',
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
          array (
            'key' => 'field_54cf9013e6420',
            'label' => 'Social networks',
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
                'key' => 'field_54cf9026e6421',
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
                  '' => '',
                ),
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 0,
                'ajax' => 0,
                'placeholder' => '',
                'disabled' => 0,
                'readonly' => 0,
              ),
              array (
                'key' => 'field_54cf9093e6422',
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
                'key' => 'field_54cf909ce6423',
                'label' => 'Url',
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
            ),
          ),
        ),
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
      array (
        array (
          'param' => 'user_type',
          'operator' => '==',
          'value' => 'editor',
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

?>