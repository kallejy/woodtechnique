<?php
/**
* Nice functions to cleanup WordPress
* and make it look and feel the way we want it to
*
* Maintained by Henrik Kensén and Kalle Nilsson of fempunkter.se
*
*/





/**
* Remove the ridiculous emoji-crap-code
*/
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );





/**
* Remove some more stuff
*/
remove_action( 'wp_head', 'feed_links', 2);
remove_action( 'wp_head', 'feed_links_extra', 3);
remove_filter('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link'); 
remove_action('wp_head', 'pingback');





/**
* Remove embed js and stuff
*/
function disable_embeds_init() {
    remove_action('rest_api_init', 'wp_oembed_register_route');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
}

add_action('init', 'disable_embeds_init', 9999);





/**
* Enqueue scripts and styles
*/
function femp_scripts() {
    wp_enqueue_script ( 'jquery' );
    wp_enqueue_style ( 'style', get_template_directory_uri() . '/style.css', array(), '1.0.0', false);
    wp_enqueue_script( 'js', get_template_directory_uri() . '/assets/js/custom.js', array(), '1.0.0', true);
  }
  
  add_action( 'wp_enqueue_scripts', 'femp_scripts' );





/**
* Move scripts and stuff to footer for faster pageload
*
remove_action('wp_head', 'wp_print_scripts');
remove_action('wp_head', 'wp_print_head_scripts', 9);
remove_action('wp_head', 'wp_enqueue_scripts', 1);
add_action('wp_footer', 'wp_print_scripts', 5);
add_action('wp_footer', 'wp_enqueue_scripts', 5);
add_action('wp_footer', 'wp_print_head_scripts', 5);*/





/**
* Add sidebar
*/
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Sidebar',
    'id' => 'sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
}





/**
* Add Custom Menus
*/
add_theme_support( 'menus' );

register_nav_menus( array(
    'main-menu' => 'Huvudmeny',
    'top-menu' => 'Toppmeny',
	'footer-menu' => 'Meny i sidfot',
) );





/**
* Removes ul from wp_nav_menu
*/
function remove_ul ( $menu ){
    return preg_replace( array( '#^<ul[^>]*>#', '#</ul>$#' ), '', $menu );
}
add_filter( 'wp_nav_menu', 'remove_ul' );





/**
* Nav fix
*/
function add_menuclass($ulclass) {
return preg_replace('/<a rel="primary-btn"/', '<a class="primary-btn"', $ulclass, 1);
return preg_replace('/<a rel="opa"/', '<a class="opa"', $ulclass, 2);
}
add_filter('wp_nav_menu','add_menuclass');





/**
* Custom Excerpt Lengths
*/
function excerpt($limit,$text = NULL) {
	if($text == NULL){
		$excerpt = explode(' ', get_the_excerpt(), $limit);
	} else {
		$excerpt = explode(' ', $text, $limit);
	}
	
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	}
	$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	return $excerpt;
}





/**
* Add post thumbnails
*/
add_theme_support( 'post-thumbnails' );
//set_post_thumbnail_size( 50, 50, true );
add_image_size( 'hero-image', 1640, 920, true );





/**
* Add Custom Post Types & Taxonomies
*/
add_action( 'init', 'create_post_type' );
function create_post_type() {
  
  # Add post type Dokument
  register_post_type( 'dokument',
      array(
          'labels' => array(
              'name' => __( 'Dokument' ),
              'singular_name' => __( 'Dokument' )
          ),
          'public' => true,
          'has_archive' => true,
          'menu_icon' => 'dashicons-media-text',
          'rewrite' => array('slug' => 'dokument'),
          'supports' => array( 'title', 'custom-fields'),
      )
  );

}

/**
* Build Taxonomies
*/
add_action( 'init', 'build_taxonomies', 0 );

function build_taxonomies() {
    register_taxonomy( 'dokumentkategori', 'dokument', array( 'hierarchical' => true, 'label' => __('Dokumentkategori', "bullerby"), 'query_var' => true, 'rewrite' => array('slug' => __('dokumentkategori')) ) ); 
}





/**
* Add ACF Options Page
*/
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> '5P inställningar',
		'menu_title'	=> '5P inställningar',
		'menu_slug' 	=> 'femp-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
}





/** 
* Spara acf-json sync
*/
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point( $path ) {
    // update path
    $path = get_stylesheet_directory() . '/acf-json';
    
    return $path;
}

// Ladda acf-json

add_filter('acf/settings/load_json', 'my_acf_json_load_point');
function my_acf_json_load_point( $paths ) {
    // remove original path (optional)
    unset($paths[0]);
    // append path
    $paths[] = get_stylesheet_directory() . '/acf-json';
    // return
    return $paths;   
}





/**
* Add label-visibility gforms
*/
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );





/**
* Create Custom WordPress Dashboard Widget
*/ 
function dashboard_widget_function() {
    echo '
        <img src="'.get_stylesheet_directory_uri().'/assets/img/fempunkter.png" alt="Fem punkter"/>
        <p>Det här är en webbplats från Fem punkter.</p>
        <p><strong>Kontakta oss:</strong><br/>
        0381-61 16 00<br/>
        <a href="http://www.fempunkter.se">fempunkter.se</a></p>
    ';
}
function add_dashboard_widgets() {
    wp_add_dashboard_widget( 'custom_dashboard_widget', 'Fem punkter', 'dashboard_widget_function' );
}
add_action( 'wp_dashboard_setup', 'add_dashboard_widgets' );






/**
* Remove All Dashboard Widgets
*/ 
function remove_dashboard_widgets() {
    global $wp_meta_boxes;
    unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
    unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
    unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
    unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
    unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts'] );
    unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
//    unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
//    unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );
  remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );



/**
* Removes comments from admin menu
*/

add_action( 'admin_menu', 'my_remove_admin_menus' );
function my_remove_admin_menus() {
  remove_menu_page( 'edit-comments.php' );
}

/**
* Removes comments from post and pages
*/
add_action( 'init', 'remove_comment_support', 100 );
function remove_comment_support() {
  remove_post_type_support( 'post', 'comments' );
  remove_post_type_support( 'page', 'comments' );
}

/**
* Removes comments from admin bar
*/
function mytheme_admin_bar_render() {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu( 'comments' );
}
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );






/**
* Remove admin bar for everyone except admins
*/
add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
  }
}





/**
* Remove default gallery inline style
*/
add_filter( 'use_default_gallery_style', '__return_false' );





/**
* Change logo on login-page
*/
function femp_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/woodtechnique_logo.svg);
            background-size: 40%;
            width: 100%;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'femp_login_logo' );