<?php
setlocale(LC_TIME, 'fr_FR');
require_once('inc/seo.php');
require_once('inc/hashbang.php');
require_once('inc/schedule-frontend.php');
require_once('inc/schedule-backend.php');
require_once('inc/socialfeed.php');

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}



/*------------------------------------*\
    HELPERS
\*------------------------------------*/


function has($v){
    return (isset($v)&&!empty($v));
}

function is_login_page() {
    return $GLOBALS['pagenow'] == 'wp-login.php';
}

function get_header_once(){
    global $post, $header_rendered, $main_ID;
    if(!has($header_rendered)){
      get_header();
      $header_rendered = true;
      $main_ID = $post->ID;
    }
}
function get_footer_once(){
    global $post, $header_rendered, $main_ID;
    if(has($main_ID) && $main_ID==$post->ID){
      wp_reset_query();
      get_footer();
    }
}

function include_page_part($ID){
    global $post;
    query_posts(array(
        'post_type' => 'page',
        'p'         => $ID
    ));
    $template = str_replace('.php','',get_page_template_slug($ID));
    if(!has($template)) $template = 'page';
    get_template_part($template);
}

function get_ID_from_slug($slug){
    global $wpdb;
    return $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '$slug'");
}


/*------------------------------------*\
    TINY MCE
\*------------------------------------*/
function tiny_stylesheet() {
    add_editor_style( 'assets/css/tinymce.css' );
}
function enable_style_select( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
function custom_tiny_styles( $init_array ) {
    // Define the style_formats array
    $style_formats = array(
        // Each array child is a format with it's own settings
        array(
            'title' => 'Main Title',
            'selector' => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table',
            'classes' => 'main title'
        ),
        array(
            'title' => 'Big Title',
            'selector' => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table',
            'classes' => 'huge title'
        ),
        array(
            'title' => 'Title',
            'selector' => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table',
            'classes' => 'title'
        ),
        array(
            'title' => 'Sub Title',
            'selector' => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table',
            'classes' => 'sub title'
        ),
        array(
            'title' => 'Small Title',
            'selector' => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table',
            'classes' => 'small title'
        ),
        array(
            'title' => 'Note',
            'selector' => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table',
            'classes' => 'note'
        )
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );
    return $init_array;

}

/*------------------------------------*\
	MENUS
\*------------------------------------*/

add_theme_support('menus');

function register_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'main' => 'Menu principal',
        'secondary' => 'Menu secondaire'
    ));
}

/*------------------------------------*\
    TAILLES D'IMAGE
\*------------------------------------*/

/* -------------------------------------------------------------------------------------------- Tailles d'Images et Crops ----------- */
// AJOUT DE TAILLES D'IMAGES

// CROP
add_image_size('wide', 900, 450, true);
add_image_size('wide retina', 1800, 900, true);
add_image_size('blog-thumb', 200, 230, false); //200 pixels wide (and unlimited height)


// RESIZE
// add_image_size('huge', 3600, 3600, false);

add_theme_support( 'post-thumbnails' );


/*------------------------------------*\
	HEAD
\*------------------------------------*/

function header_scripts()
{
    if (!is_admin() && !is_login_page()) {
        // wp_register_script('shim', '/js/html5shiv.js', array(), null);
        // wp_enqueue_script('shim');

        wp_register_script('modernizr', get_template_directory_uri() . '/assets/js/modernizr.custom.js', array(), null);
        wp_enqueue_script('modernizr');

        wp_register_script('googlemap', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array(), null);
        wp_enqueue_script('googlemap');

        wp_deregister_script('jquery'); // Deregister WordPress jQuery
        // wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js', array(), '1.10.1'); // Google CDN jQuery
        wp_register_script('jquery', get_template_directory_uri() . '/assets/js/jquery.js', array(), '1.11.1'); // fallback
        wp_enqueue_script('jquery'); // Enqueue it!

        wp_register_script('easing', get_template_directory_uri() . '/assets/js/jquery.bez.js', array(), null);
        wp_enqueue_script('easing');

        wp_register_script('cookies', get_template_directory_uri() . '/assets/js/jquery.cookie.js', array(), null);
        wp_enqueue_script('cookies');

        wp_register_script('tabs', get_template_directory_uri() . '/assets/js/tabs.js', array(), null);
        wp_enqueue_script('tabs');

        wp_register_script('raf', get_template_directory_uri() . '/assets/js/raf.js', array(), null);
        wp_enqueue_script('raf');

        wp_register_script('scrollEvents', get_template_directory_uri() . '/assets/js/scrollEvents.js', array(), null);
        wp_enqueue_script('scrollEvents');

        wp_register_script('sticky', get_template_directory_uri() . '/assets/js/sticky.js', array(), null);
        wp_enqueue_script('sticky');

        wp_register_script('breakpoints', get_template_directory_uri() . '/assets/js/breakpoints.min.js', array(), null);
        wp_enqueue_script('breakpoints');

        wp_register_script('grab', get_template_directory_uri() . '/assets/js/grab.min.js', array(), null);
        wp_enqueue_script('grab');

        wp_register_script('sides', get_template_directory_uri() . '/assets/js/sides.min.js', array(), null);
        wp_enqueue_script('sides');


        wp_register_script('map', get_template_directory_uri() . '/assets/js/map.js', array(), null);
        wp_enqueue_script('map');


        wp_register_script('custom', get_template_directory_uri() . '/assets/js/main.js', array(), null);
        wp_enqueue_script('custom');

    }
    /* ---------------------------------------------------------------------------------------------- Admin JavaScript  ---------- */
    // SCRIPT ADMIN
    //
    // else{
    //     wp_register_script('admin', '/assets/js/admin.js');
    //     wp_enqueue_script('admin');
    // }

}


function header_styles()
{
    wp_register_style('main', get_template_directory_uri() . '/assets/css/application.css');
    wp_enqueue_style('main'); // Enqueue it!
}


/* ---------------------------- */
// CSS POUR L'ADMIN

function admin_style() {
    wp_register_style('admin', get_template_directory_uri() . '/assets/css/admin.css');
    wp_enqueue_style('admin');
}

/*------------------------------------*\
    LOGIN/REGISTER FORM
\*------------------------------------*/

// http://www.danielauener.com/build-fully-customized-wordpress-login-annoying-redirects/
function before_login_form(){
    echo '<div class="facebook-account">';
        __('Connectez-vous avec','waq');
        do_action( 'wordpress_social_login' );
    echo '</div>';
    echo '<div class="wp-account">'.
            '<span class="centered border-middle">'.__('Ou','waq').'</span>';
}
function after_login_form(){
    echo '</div>';
}
function login_fail( $username ) {
    $referrer = $_SERVER['HTTP_REFERER'];
    if (!empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
        wp_redirect( strtok($referrer, '?').'?login=failed' );
        exit;
    }
}
function redirect_login($redirect_to, $url, $user) {
    if(empty($_SERVER['HTTP_REFERER'])) return;
    $referrer = $_SERVER['HTTP_REFERER'];
    $errors_keys = [];
    foreach($user->errors as $error=>$message)
        $errors_keys[] = $error;
    if(count($errors_keys)>0){
        wp_redirect(    strtok($referrer, '?').
                        '?login='.implode('+', $errors_keys).
                        (has($_POST['log'])?'&user='.urlencode($_POST['log']):'')
                    );
        exit;
    }else{
        wp_redirect( strtok($referrer, '?').'?login=empty');
        exit;
    }
}
function authenticate_user($user, $username, $password ) {
    if(empty($_SERVER['HTTP_REFERER'])) return;
    $referrer = $_SERVER['HTTP_REFERER'];
    if(!isset($_POST['log'])){
        wp_redirect( strtok($referrer, '?').'?registration=success' );
        exit;
    }
    return $user;
}


function registration_form_errors($errors, $user_login, $user_email) {
    if(empty($_SERVER['HTTP_REFERER'])) return;
    $referrer = $_SERVER['HTTP_REFERER'];
    $errors_keys = [];
    foreach($errors->errors as $error=>$message)
        $errors_keys[] = $error;
    if(count($errors_keys)>0){
        wp_redirect(    strtok($referrer, '?').
                        '?registration='.implode('+', $errors_keys).
                        (has($user_login)?'&user='.urlencode($user_login):'').
                        (has($user_email)?'&email='.urlencode($user_email):'')
                    );
        exit;
    }
    return $errors;
}
function register_user( $user_id ) {
    if(isset( $_POST['user_name']))
        update_user_meta($user_id, 'first_name', $_POST['user_name']);
}
/*------------------------------------*\
     OPTIONS EN VRAC
\*------------------------------------*/


// Remove the <div> surrounding the dynamic navigation to cleanup markup
function remove_nav_wrapper($args = '')
{
    $args['container'] = false;
    return $args;
}
function css_class_filter($classes, $item)
{
    if(is_array($classes)){
        $klasses = array();
        $id = get_post_meta($item->ID, '_menu_item_object_id', true);
        $post = get_post($id);
        $slug = $post->post_name;
        array_push($klasses, $slug);
        if(in_array('current-menu-item', $classes)){ array_push($klasses, 'active'); }
        else { array_push($klasses, ''); }

        return $klasses;
    }
    else{
        return $klasses;
    }
}
// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    // print_r($var);
    $klasses = array($var[0]);
    if(is_array($var)){
        if(in_array('current-menu-item', $var)){ array_push($klasses, 'active'); }
    }
    return is_array($var) ? $klasses : '';
}

function my_body_class_filter($var)
{
    $klasses = is_admin_bar_showing() ? array('admin-bar') : array();
    return is_array($var) ? $klasses : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}


/* ------------------------------------------------------------------------------------------------- body.slug ----------------- */
// AJOUTER LA CLASSE «SLUG» AU BODY

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }
    return $classes;
}


// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function blankwp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function blankwp_index($length) // Create 20 Word Callback for Index page Excerpts, call using blankwp_excerpt('blankwp_index');
{
    return 45;
}
//Fonction pour remplacer le [...] du excerpt par un texte plus intuitif
function new_excerpt_more($output) {
    return '... <a href="'. get_permalink() . '" class="link-status" title="'. the_title('', '', false).'">Lire la suite</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');
// Remove Admin bar
function remove_admin_bar()
{
    return false;
}


// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}
/* --------------------------------------------------------------------------------------------------- Remove Menu Items ----- */
// Remove menu items
function remove_menus() {
    global $menu;
    $restricted = array(__('Links'), __('Comments'));
    end ($menu);
    while (prev($menu)){
        $value = explode(' ',$menu[key($menu)][0]);
        if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
    }
}

/* --------------------------------------------------------------------------------------------------- Remove Comments Support -- */
//
// Remove comment so you don't get spammed
//
function remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
    remove_post_type_support( 'attachment', 'comments' );
}


/* -------------------------------------------------------------------------------------------------- Custom Post Types ------- */


/*------------------------------------*\
    THEME
\*------------------------------------*/

function enable_more_buttons($buttons) {
    $buttons[] = 'hr';
    $buttons[] = 'sub';
    $buttons[] = 'sup';
    return $buttons;
}

// --------------------------------------------
//
// REWRITE RULES
//
//

function themes_dir_add_rewrites() {
  $theme_name = get_template();

  global $wp_rewrite;

  $new_non_wp_rules = array(
    '(.css)'       => 'app/themes/' . $theme_name . '/assets/$1',
    'css/(.*)'       => 'app/themes/' . $theme_name . '/assets/css/$1',
    'js/(.*)'        => 'app/themes/' . $theme_name . '/assets/js/$1',
    'img/(.*)'    => 'app/themes/' . $theme_name . '/assets/img/$1',
    'fonts/(.*)'       => 'app/themes/' . $theme_name . '/assets/fonts/$1',
    'svg/(.*)'       => 'app/themes/' . $theme_name . '/assets/svg/$1'
  );
  $wp_rewrite->non_wp_rules += $new_non_wp_rules;
}



/* -------------------------------------------------------------------------------------------------- Variable après le slug ------- */
//
// AJOUTER UN VARIABLE À UN "/" APRÈS LE SLUG
//

function add_endpoint()
{
    add_rewrite_endpoint('filtre', EP_PERMALINK | EP_PAGES );
    add_rewrite_endpoint('horaire', EP_PERMALINK | EP_PAGES );
}



/*------------------------------------*\
    Actions + Filters + ShortCodes
\*------------------------------------*/

//
//  Add Actions
//

add_action('wp_enqueue_scripts', 'header_styles');
add_action('admin_enqueue_scripts', 'admin_style');   // Css pour l'admin
add_action('init', 'header_scripts');
add_action('init', 'register_menu');
add_action('init', 'remove_comment_support');
add_action('init', 'add_endpoint');   // Ajouter une variables domain.com/slug/var  (voir aussi add_filter)
add_action('generate_rewrite_rules', 'themes_dir_add_rewrites'); // Rewrite des URLs
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('admin_menu', 'remove_menus'); // Enlever des éléments dans le menu Admin
add_action('wp_login_failed', 'login_fail');
add_action('user_register', 'register_user', 10, 1);
add_action('login_redirect', 'redirect_login', 10, 3);
//
//  Remove Actions
//
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

//
//
// Add Filters


add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images
add_filter('wp_nav_menu_args', 'remove_nav_wrapper'); // Remove surrounding <div> from WP Navigation
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter( 'excerpt_length', 'blankwp_index', 999 );
add_filter('nav_menu_css_class', 'css_class_filter', 10, 2); // Remove Navigation <li> injected classes (Commented out by default)
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('body_class', 'my_body_class_filter', 10, 2); // Remove <body> injected classes (Commented out by default)
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter("mce_buttons", "enable_more_buttons"); // Ajouter des boutons custom au WYSIWYG
add_filter( 'tiny_mce_before_init', 'custom_tiny_styles');
add_filter('mce_buttons_2', 'enable_style_select');
add_action('init', 'tiny_stylesheet' );
add_filter('authenticate', 'authenticate_user', 1, 3);
add_filter('login_form_top','before_login_form',10,0);
add_filter('login_form_bottom','after_login_form',10,0);
add_filter('registration_errors', 'registration_form_errors', 10, 3);
?>