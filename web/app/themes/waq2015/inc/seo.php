<?php
/*------------------------------------*\
    SEO
\*------------------------------------*/


if( function_exists('register_field_group') ):

  function acf_seo(){
    global $post, $wp_query, $current_user;
    $is_author_page = is_author();
    $vars = $wp_query->query_vars;
    $title = get_bloginfo('name');
    $description = '';
    $keywords = '';
    $og_image = '';
    $pageTitle = '';
    $url = get_home_url();
    if(isset($post) && !$is_author_page){
      setup_postdata($post);
      $description = get_field('description');
      $keywords = get_field('keywords');
      $og_image = get_field('og_image');
      if($post->post_name=='mon-horaire'){
        $url .= '/horaire/'.$current_user->user_login;
        $pageTitle = $current_user->data->display_name;
      }
      else{
        $url = get_permalink();
        $pageTitle = get_field('title');
      }
    }

    elseif(isset($vars['author_name']) || isset($vars['author'])){
      $profile = isset($vars['author_name']) ? get_user_by('slug', $vars['author_name']) : $vars['author'];
      $account_page_ID = get_ID_from_slug('mon-horaire');
      $url .= '/horaire/'.$profile->user_login;
      $description = get_field('description', $account_page_ID);
      $keywords = get_field('keywords', $account_page_ID);
      $og_image = get_field('og_image', $account_page_ID);
      $pageTitle = __('L\'horaire de', 'waq').' '.$profile->data->display_name;
    }

    if(!has($description)) $description = get_field('description', 'options');
    if(!has($keywords)) $keywords = get_field('keywords', 'options');
    if(!has($og_image)) $og_image = get_field('og_image', 'options');
    if(!has($pageTitle)) $pageTitle = get_field('title', 'options');
    if(!has($pageTitle) && !is_front_page()){ $pageTitle = get_the_title(); }

    if(has($pageTitle)) $title = $pageTitle." • ".$title;
    ?>

    <title><?= $title?></title>
    <meta name="description" content="<?= $description ?>" />
    <meta name="keyword" content="<?= $keywords ?>" />
    <meta property="og:title" content="<?= $title ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?= $url ?>" />
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
    'menu_order' => 10,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
  ));

endif;

?>