<?php
/*------------------------------------*\
    SEO
\*------------------------------------*/


if( function_exists('register_field_group') ):

  function acf_seo(){
    global $post;
    setup_postdata($post);
    $description = get_field('description');
    if(!has($description)) $description = get_field('description', 'options');
    $keywords = get_field('keywords');
    if(!has($keywords)) $keywords = get_field('keywords', 'options');
    $og_image = get_field('og_image');
    if(!has($og_image)) $og_image = get_field('og_image', 'options');
    $title = get_field('title');
    if(!has($title)) $title = get_field('title', 'options');

    $title = get_bloginfo('name');
    $pageTitle = get_field('title');
    if(!$pageTitle && !is_front_page()){ $pageTitle = get_the_title(); }
    if(has($pageTitle)){ $title = $pageTitle." • ".$title; }

    ?>

    <title><?= $title?></title>
    <meta name="description" content="<?= $description ?>" />
    <meta name="keyword" content="<?= $keywords ?>" />
    <meta property="og:title" content="<?= $title ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?= get_permalink() ?>" />
    <meta property="og:site_name" content="<?= get_bloginfo('name') ?>"/>
    <meta property="og:description" content="<?= $description ?>"/>
    <meta property="og:image" content="<?= $og_image['url'] ?>" />
    <?php

  }


  register_field_group(array (
    'key' => 'group_548a416bebfd6',
    'title' => 'SEO',
    'fields' => array (
      array (
        'key' => 'field_548a48225c570',
        'label' => 'Titre',
        'name' => 'title',
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
        'key' => 'field_548a458878c4c',
        'label' => 'OG image',
        'name' => 'og_image',
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
        'key' => 'field_548a41875ca03',
        'label' => 'Mots-clés',
        'name' => 'keywords',
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
        'new_lines' => '',
        'readonly' => 0,
        'disabled' => 0,
      ),
      array (
        'key' => 'field_548a419a5ca04',
        'label' => 'Description',
        'name' => 'description',
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
        'new_lines' => '',
        'readonly' => 0,
        'disabled' => 0,
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
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'page',
        ),
      ),
      array (
        array (
          'param' => 'options_page',
          'operator' => '==',
          'value' => 'acf-options',
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