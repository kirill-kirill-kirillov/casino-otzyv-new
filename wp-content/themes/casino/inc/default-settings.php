<?php

/*if ( isset( $_GET['debug'] ) && (int) $_GET['debug'] === 1 ) {
    ! WP_DEBUG ? define( 'WP_DEBUG', true ) : null;
    ! WP_DEBUG_DISPLAY ? define( 'WP_DEBUG_DISPLAY', true ) : null;
    @ini_set( 'display_errors', 'On' );
    @error_reporting( 'E_ALL' );
}*/

function debug( $array ) {
    echo '<pre>';
    var_dump( $array );
    echo '</pre>';
}

add_action( 'wp_enqueue_scripts', 'cj_scripts' );
function cj_scripts() {
    /**
     * Enable cache busting of enqueued css and javascript
     *
     * To disable, change WP_ENV to production
     */
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js', [], '3.4.1', false );
    wp_enqueue_script( 'jquery' );

    wp_enqueue_script( 'comment-reply' );

    //wp_enqueue_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js' );
    wp_enqueue_script( 'formstyler', 'https://cdnjs.cloudflare.com/ajax/libs/jQueryFormStyler/2.0.2/jquery.formstyler.min.js' );
    //wp_enqueue_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css' );
    wp_enqueue_style( 'formstyler', 'https://cdnjs.cloudflare.com/ajax/libs/jQueryFormStyler/2.0.2/jquery.formstyler.min.css' );
    wp_enqueue_style( 'formstyler-theme', 'https://cdnjs.cloudflare.com/ajax/libs/jQueryFormStyler/2.0.2/jquery.formstyler.theme.min.css' );



    wp_enqueue_style( 'styles', get_stylesheet_uri(), [], filemtime( get_template_directory() . '/style.css' ) );
    wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', [ 'jquery' ], filemtime( get_template_directory() . '/js/scripts.js' ), true );

    wp_localize_script(
        'scripts',
        'cj_ajax',
        array(
            'url'   => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'cj_ajax-nonce' ),
        )
    );
}

add_action( 'admin_enqueue_scripts', 'cj_add_blocks_styles_editor' );
function cj_add_blocks_styles_editor() {
    wp_enqueue_style( 'admin-styles', get_template_directory_uri() . '/wp-admin.css', [], filemtime( get_template_directory() . '/wp-admin.css' ) );
    wp_enqueue_script( 'admin-scripts', get_template_directory_uri() . '/wp-admin.js', [ 'jquery' ], filemtime( get_template_directory() . '/wp-admin.js' ), true );
}

add_action( 'after_setup_theme', 'cj_setup' );
function cj_setup() {
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce' );

    add_theme_support(
        'html5',
        [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ]
    );

    add_theme_support(
        'custom-logo',
        [
            'height'      => 1000,
            'width'       => 1000,
            'flex-width'  => true,
            'flex-height' => true,
        ]
    );

    register_nav_menus(
        [
            'main_menu'     => esc_html__( 'Главное меню', 'cj' ),
        ]
    );

    /**
     * Register additional Post Thumbnail sizes.
     *
     * Default sizes for reference:
     * add_image_size( 'thumbnail', 150, 150, true );
     * add_image_size( 'medium', 300, 300, false );
     * add_image_size( 'medium_large', 768, '', false );
     * add_image_size( 'large', 1024, 1024, false );
     */

    add_image_size( 'casino-review-teaser', 140, 94, false );
    add_image_size( 'casino-review-full', 274, 184, false );
    add_image_size( 'post-teaser', 505, 200, false );
    add_image_size( 'top-10-teaser', 76, 50, true );
    /*add_image_size( 'product-teaser', 300, 200, false );
    add_image_size( 'product-main', 450, 300, false );*/
    /*add_image_size( 'top-block', 1280, 500, false );
    add_image_size( 'service', 300, 185, false );
    add_image_size( 'client', 270, 150, false );
    add_image_size( 'testimonial', 220, 220, false );
    add_image_size( 'blog-big', 770, 420, false );
    add_image_size( 'blog-rand', 735, 395, false );*/

    /**
     * Enable support for Post Formats.
     * See https://developer.wordpress.org/themes/functionality/post-formats/
     */

    // add_theme_support( 'post-formats', array(
    //   'aside',
    //   'image',
    //   'video',
    //   'quote',
    //   'link',
    // ) );

    /**
     * Enable excerpts on 'pages'.
     */
    // add_post_type_support( 'page', 'excerpt' );

    /**
     * Add theme support for selective refresh for widgets.
     */
    // add_theme_support( 'customize-selective-refresh-widgets' );
}

if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page(
        [
            'page_title' => 'Опции сайта',
            'menu_title' => 'Опции сайта',
            'menu_slug'  => 'site_options',
            'redirect'   => false,
        ]
    );
}

add_filter( 'upload_mimes', 'cj_myme_types', 99 );
function cj_myme_types( $mime_types ) {
    $mime_types['svg'] = 'image/svg+xml';
    return $mime_types;
}

function cj_custom_acf_block_render_callback( $block ) {
    $slug = str_replace( 'acf/', '', $block['name'] );

    // include a template part from within the "template-parts/block" folder
    if ( file_exists( get_theme_file_path( "/template-parts/blocks/content-{$slug}.php" ) ) ) {
        include get_theme_file_path( "/template-parts/blocks/content-{$slug}.php" );
    }
}

/*add_action('admin_init', 'cj_ban_admin_panel');
function cj_ban_admin_panel() {
    if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( home_url() );
        exit;
    }
}*/

add_action( 'after_setup_theme', 'cj_remove_admin_bar' );
function cj_remove_admin_bar() {
    if ( ! current_user_can( 'administrator' ) && ! is_admin() ) {
        show_admin_bar( false );
    }
}

/**
 * Load Google fonts asynchronously
 */
add_action( 'wp_head', 'wps_google_font_js' );
function wps_google_font_js() {
    ?>

    <script type="text/javascript">
        WebFontConfig = {
            google: { families: [ 'Manrope:400,500,600,700,800' ] },
        };
        (function () {
            var wf = document.createElement( 'script' );
            wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName( 'script' )[ 0 ];
            s.parentNode.insertBefore( wf, s );
        })();
    </script>

    <?php
}