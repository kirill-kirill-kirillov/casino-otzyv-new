<?php

require_once 'inc/cleaner.php';
require_once 'inc/default-settings.php';
require_once 'inc/class-siteoptions.php';
require_once 'inc/ACF_Field_Unique_ID.php';
/*require_once ABSPATH .'wp-admin/includes/template.php';*/

PhilipNewcomer\ACF_Unique_ID_Field\ACF_Field_Unique_ID::init();

add_filter('acf/load_field', 'acf_read_only');
function acf_read_only( $field ) {
    if ( $field['name'] === 'id_review' || $field['name'] === 'id_comment' ) {
        $field['readonly'] = 1;
    }

    return $field;
}

add_action( 'acf/save_post', 'cj_casino_comment_create' );
function cj_casino_comment_create( $post_id ) {
    $post_type  = get_post_type( $post_id );
    $id_comment = get_field( 'id_comment', $post_id ) ? (int) get_field( 'id_comment', $post_id ) : '';

    if ( $post_type === 'casino-review' && ! $id_comment ) {
        $title_casino = get_field( 'title', $post_id ) ? get_field( 'title', $post_id ) : '';

        $post_data = array(
            'post_title'  => 'Отзывы игроков о казино ' . $title_casino,
            'post_status' => 'publish',
            'post_type'   => 'casino-comment',
        );

        $insert_post_id = wp_insert_post( wp_slash( $post_data ) );

        update_field( 'id_comment', (int) $insert_post_id, (int) $post_id );
        update_field( 'id_review', (int) $post_id, (int) $insert_post_id );

        if ( ! wp_next_scheduled( 'change_casino_permalink' ) ) {
            wp_schedule_single_event( time(), 'change_casino_permalink', [ (int) $post_id, (int) $insert_post_id ], true );
        }

        $rmp_vote_count     = get_post_meta( (int) $post_id, 'rmp_vote_count', true ) ? get_post_meta( $post_id, 'rmp_vote_count', true ) : 0;
        $rmp_rating_val_sum = get_post_meta( (int) $post_id, 'rmp_rating_val_sum', true ) ? get_post_meta( $post_id, 'rmp_rating_val_sum', true ) : 0;
        $rmp_avg_rating     = get_post_meta( (int) $post_id, 'rmp_avg_rating', true ) ? get_post_meta( $post_id, 'rmp_avg_rating', true ) : 0;
        update_post_meta( $post_id, 'rmp_vote_count', $rmp_vote_count );
        update_post_meta( $post_id, 'rmp_rating_val_sum', $rmp_rating_val_sum );
        update_post_meta( $post_id, 'rmp_avg_rating', $rmp_avg_rating );
    }
}

/*add_action( 'delete_post', 'action_function_name_7835', 10, 2 );
function action_function_name_7835( $post_id, $post ){
    $id_comment = get_post_meta( $post_id, 'id_comment', true ) ? get_post_meta( $post_id, 'id_comment', true ) : '';


    if ( $id_comment ) {
        wp_delete_post( $id_comment );
    }
}*/

add_action( 'edit_post', 'action_function_name_4135', 10, 2 );
function action_function_name_4135( $post_id, $post ){
    $id_comment = get_post_meta( $post_id, 'id_comment', true ) ? get_post_meta( $post_id, 'id_comment', true ) : '';

    if ( $id_comment && $post->post_type === 'casino-review' && $post->post_status === 'trash' ){
        wp_update_post( [
            'ID'          => $id_comment,
            'post_status' => 'trash'
        ] );
    }
}

add_action( 'change_casino_permalink', 'cj_change_casino_permalink', 10, 2 );
function cj_change_casino_permalink( $post_id, $insert_post_id ) {
    $cyr_to_lat = new \Cyr_To_Lat\Main();

    $title = get_field( 'title', $post_id ) ? urldecode( strtolower( esc_html( get_field( 'title', $post_id ) ) ) ) : '';
    $title = strtolower( $cyr_to_lat->sanitize_title( $title ) );
    $title = str_replace( ' ', '-', $title );

    update_post_meta( $post_id, 'custom_permalink', 'casino-' . $title . '-obzor/' );
    update_post_meta( $insert_post_id, 'custom_permalink', 'casino-' . $title . '-otzyvy/' );
}

add_filter( 'get_default_comment_status', 'cj_enable_comments', 10, 3 );
function cj_enable_comments( $status, $post_type, $comment_type ) {
    if ( $post_type === 'casino-comment' ) {
        if ( in_array( $comment_type, array( 'pingback', 'trackback' ) ) ) {
            $status = get_option( 'default_ping_status' );
        } else {
            $status = get_option( 'default_comment_status' );
        }
    }
    return $status;
}

/*add_filter ('rmp_display_rating_widget', 'blazzdev_show_rating_widget');
function blazzdev_show_rating_widget () {
    if ( get_post_type() == 'casino-review' ) {
        return false;
    }

    return true;
}*/

/*add_filter( 'post_type_link', 'filter_function_name_9498', 999, 4 );
function filter_function_name_9498( $post_link, $post, $leavename, $sample ){*/
   /* if ( $post->post_type === 'casino-review' ) {
        $cyr_to_lat = new \Cyr_To_Lat\Main();

        $title      = get_field( 'title', $post->ID ) ? urldecode( get_field( 'title', $post->ID ) ) : '';
        $title      = $cyr_to_lat->sanitize_title( $title );
        $title      = str_replace( ' ', '-', $title );

        $post_link = $_SERVER['REQUEST_SCHEME']  . '://' . $_SERVER['SERVER_NAME'] .  '/casino-' . $title . '-obzor';
    }

    debug($post_link);*/

/*    return $post_link;
}*/



/*add_action( 'pre_get_posts', 'cj_parse_request' );
function cj_parse_request( $query ){
    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', [ 'post', 'page', 'casino-review', 'casino-comment' ] );
    }
}*/

add_action( 'acf/init', 'cj_custom_acf_init' );
function cj_custom_acf_init() {
    if ( function_exists( 'acf_register_block' ) ) {
        acf_register_block(
            array(
                'name'            => 'important',
                'title'           => __( 'Важно' ),
                'render_callback' => 'cj_custom_acf_block_render_callback',
                'category'        => 'formatting',
                'icon'            => 'schedule',
                'supports'        => array(),
                'mode'            => 'edit',
            )
        );

        acf_register_block(
            array(
                'name'            => 'answers',
                'title'           => __( 'Ответы на вопросы' ),
                'render_callback' => 'cj_custom_acf_block_render_callback',
                'category'        => 'formatting',
                'icon'            => 'schedule',
                'supports'        => array(),
                'mode'            => 'edit',
            )
        );

        acf_register_block(
            array(
                'name'            => 'anchors',
                'title'           => __( 'Содержание' ),
                'render_callback' => 'cj_custom_acf_block_render_callback',
                'category'        => 'formatting',
                'icon'            => 'schedule',
                'supports'        => array(),
                'mode'            => 'edit',
            )
        );
    }
}

function num_declension( $number, $titles ) {
    $abs = abs( $number );
    $cases = array( 2, 0, 1, 1, 1, 2 );
    return "<span>" . $number . "</span>" . " " . $titles[ ( $abs % 100 > 4 && $abs % 100 < 20 ) ? 2 : $cases[ min( $abs % 10, 5 ) ] ];
}


if ( wp_doing_ajax() ) {

    add_action( 'wp_ajax_nopriv_pr_update_rating', 'pr_ajax_update_rating' );
    add_action( 'wp_ajax_pr_update_rating', 'pr_ajax_update_rating' );
    function pr_ajax_update_rating() {
        if ( ! wp_verify_nonce($_POST['nonce_code'], 'cj_ajax-nonce') ) wp_send_json_error();

        if ( ! isset($_POST['id']) ) wp_send_json_error();

        $id = intval( $_POST['id'] );
        if ( ! $id ) wp_send_json_error();

        $avg_rating = floatval( rmp_get_avg_rating($id) );
        $vote_count = rmp_get_vote_count( $id );

        $html = array(
            'rating' => array(
                'current' => pr_get_current_rating_html( $avg_rating ),
                'count' => pr_get_vote_html( $vote_count ),
                'stars' => rmp_get_visual_rating( $id ),
            ),
        );

        wp_send_json_success( array( 'html' => $html ) );
    }

}

function pr_get_current_rating_html( $avg_rating ) {
    ob_start();
    ?>

    <span><?php echo $avg_rating; ?></span>/5

    <?php
    return ob_get_clean();
}


function pr_get_vote_html( $vote_count ) {
    ob_start();

    ?>
    <img src="<?php bloginfo( 'template_directory' ); ?>/images/votes.svg" alt="">
    <span><?php echo num_declension( (int) $vote_count, [ 'голос', 'голоса', 'голосов' ] ); ?></span>

    <?php
    return ob_get_clean();
}

/*add_action('init', 'do_rewrite');
function do_rewrite(){
    // Правило перезаписи
    add_rewrite_rule( '^([^/]*)/([^/]*)/?', 'index.php/$matches[1]-$matches[2]', 'top' );
    // нужно указать ?p=123 если такое правило создается для записи 123
    // первый параметр для записей: p или name, для страниц: page_id или pagename

    // скажем WP, что есть новые параметры запроса
    add_filter( 'query_vars', function( $vars ){
        $vars[] = 'food';
        $vars[] = 'variety';
        return $vars;
    } );
}*/


add_shortcode( 'check_game', 'shortode_check_game' );
function shortode_check_game( $attr ) {
    $post_id   = get_the_ID();
    $title     = get_field( 'title', $post_id ) ? get_field( 'title', $post_id ) : '';
    $link      = get_field( 'link', $post_id ) ? get_field( 'link', $post_id ) : '';
    $games     = get_field( 'games', 'option' ) ? get_field( 'games', 'option' ) : '';
    $games_arr = explode( PHP_EOL, $games );

	ob_start(); ?>

    <?php if ( $games ) : ?>
        <div class="review-check-game">
            <div class="review-check-game__title">
                Проверить наличие игры <span>в <?php echo $title; ?></span>
            </div>
            <div class="review-check-game__main">
                <div class="review-check-game__main-title">Выберите игру</div>
                <div class="review-check-game__main-block">
                    <select class="js-select">
                        <?php foreach ( $games_arr as $key => $game ) : ?>
                            <option><?php echo esc_html( $game ); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <a href="#" id="check_game_btn" class="btn btn_blue_line">Проверить</a>
                </div>
            </div>
            <div class="review-check-game__success" style="display: none;">
                <hr>
                <div class="review-check-game__success-title">Игра найдена</div>
                <?php if ( $link ) : ?>
                    <?php echo do_shortcode('[prgpattern slug="' . esc_url( $link ) . '" title="Играть" extern="true" class="form-red-btn form-red-btn_review-check-game"]'); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php
	wp_reset_query();
	$data = ob_get_contents();
	ob_end_clean();

	return $data;
}

/*add_action( 'rmp_after_vote', 'blazzdev_after_vote', 10, 4 );
function blazzdev_after_vote( $post_id, $new_avg_rating, $new_vote_count, $submitted_rating ) {
    $id_comment = get_post_meta( $post_id, 'id_comment', true ) ? get_post_meta( $post_id, 'id_comment', true ) : get_post_meta( $post_id, 'id_review', true );

    setcookie( $post_id, $submitted_rating, time() + 60 * 60 * 24 * 30 * 12, '/' );
    setcookie( $id_comment, $submitted_rating, time() + 60 * 60 * 24 * 30 * 12, '/' );

    $rmp_rate = isset( $_COOKIE['rmp-rate'] ) ? $_COOKIE['rmp-rate'] : '';
    if ( $rmp_rate ) {
        if ( $rmp_rate ) {
            $rmp_rate = explode( ',', $rmp_rate );
        }
        $rmp_rate[] = $post_id;
        $rmp_rate[] = $id_comment;

        $rmp_rate = implode( ',', $rmp_rate );
        setcookie( 'rmp-rate', $rmp_rate, time() + 60 * 60 * 24 * 30 * 12 * 5, '/' );
    } else {
        setcookie( 'rmp-rate', $post_id . ',' . $id_comment, time() + 60 * 60 * 24 * 30 * 12 * 5, '/' );
    }

}*/

//update_post_meta( 156, 'stars_comments', array() );


add_action( 'comment_post', 'action_function_name_11', 10, 3 );
function action_function_name_11( $comment_ID, $comment_approved, $commentdata ) {
    //$rmp_rate           = isset( $_COOKIE['rmp-rate'] ) ? $_COOKIE['rmp-rate'] : '';
    $rating             = isset( $_POST['rating'] ) ?  (int) $_POST['rating'] : '';

    $post_id            = (int) $commentdata['comment_post_ID'];
    $comment_ID         = (int) $comment_ID;
    $user               = wp_get_current_user();
    $user_id            = (int) $user->data->ID;
    /*$rmp_vote_count     = get_post_meta( $post_id, 'rmp_vote_count' ) ? get_post_meta( $post_id, 'rmp_vote_count', true ) : 0;
    $rmp_rating_val_sum = get_post_meta( $post_id, 'rmp_rating_val_sum' ) ? get_post_meta( $post_id, 'rmp_rating_val_sum', true ) : 0;
    $rmp_avg_rating     = get_post_meta( $post_id, 'rmp_avg_rating', true ) ? get_post_meta( $post_id, 'rmp_avg_rating', true ) : 0;*/

    if ( $rating ) {
        $stars_comments = get_post_meta( $post_id, 'stars_comments', true ) ? get_post_meta( $post_id, 'stars_comments', true ) : array();
        $stars_comments[$user_id] = $rating;
        update_post_meta( $post_id, 'stars_comments', $stars_comments );

        setcookie( $post_id, $rating, time() + 60 * 60 * 24 * 30 * 12 * 10, get_the_permalink( $post_id ) );
    }

    /*if ( $rmp_rate ) {
        $rmp_rate   = explode( ',', $rmp_rate );
        $rmp_rate[] = $commentdata['comment_post_ID'];

        $rmp_rate = implode( ',', $rmp_rate );
        setcookie( 'rmp-rate', $rmp_rate, time() + 60 * 60 * 24 * 30 * 12 * 5 );
    } else {
        setcookie( 'rmp-rate', $commentdata['comment_post_ID'] . ',' . $id_comment, time() + 60 * 60 * 24 * 30 * 12 * 5 );
    }

    $rating_count = $rmp_vote_count++;
    $rating_sum   = $rmp_rating_val_sum + $rating;
    $rating_total = $rating_sum / $rating_count;

    update_post_meta( $id_comment, 'rmp_vote_count', $rmp_vote_count );
    update_post_meta( $id_comment, 'rmp_rating_val_sum', $rating_sum );
    update_post_meta( $id_comment, 'rmp_avg_rating', $rating_total );

    setcookie( $commentdata['comment_post_ID'], $rating, time() + 60 * 60 * 24 * 30 * 12 * 5 );
    setcookie( $id_comment, $rating, time() + 60 * 60 * 24 * 30 * 12 * 5 );*/
}


// Remove taxonomy from url and redirect
add_filter('request', 'rudr_change_term_request', 1, 1 );
function rudr_change_term_request($query){
    $tax_name = 'category_review'; // specify you taxonomy name here, it can be also 'category' or 'post_tag'

    // Request for child terms differs, we should make an additional check
    if( $query['attachment'] ) :
        $include_children = true;
        $name = $query['attachment'];
    else:
        $include_children = false;
        $name = $query['name'];
    endif;


    $term = get_term_by('slug', $name, $tax_name); // get the current term to make sure it exists

    if (isset($name) && $term && !is_wp_error($term)): // check it here

        if( $include_children ) {
            unset($query['attachment']);
            $parent = $term->parent;
            while( $parent ) {
                $parent_term = get_term( $parent, $tax_name);
                $name = $parent_term->slug . '/' . $name;
                $parent = $parent_term->parent;
            }
        } else {
            unset($query['name']);
        }

        switch( $tax_name ):
            case 'category':{
                $query['category_name'] = $name; // for categories
                break;
            }
            case 'post_tag':{
                $query['tag'] = $name; // for post tags
                break;
            }
            default:{
                $query[$tax_name] = $name; // for another taxonomies
                break;
            }
        endswitch;

    endif;

    return $query;

}

add_filter( 'term_link', 'rudr_term_permalink', 10, 3 );
function rudr_term_permalink( $url, $term, $taxonomy ){

    $taxonomy_name = 'category_review'; // your taxonomy name here
    $taxonomy_slug = 'category_review'; // the taxonomy slug can be different with the taxonomy name (like 'post_tag' and 'tag' )

    // exit the function if taxonomy slug is not in URL
    if ( strpos($url, $taxonomy_slug) === FALSE || $taxonomy != $taxonomy_name ) return $url;

    $url = str_replace('/' . $taxonomy_slug, '', $url);

    return $url;
}

add_action('template_redirect', 'rudr_old_term_redirect');
function rudr_old_term_redirect() {

    $taxonomy_name = 'category_review';
    $taxonomy_slug = 'category_review';

    // exit the redirect function if taxonomy slug is not in URL
    if( strpos( $_SERVER['REQUEST_URI'], $taxonomy_slug ) === FALSE)
        return;

    if( ( is_category() && $taxonomy_name=='category' ) || ( is_tag() && $taxonomy_name=='post_tag' ) || is_tax( $taxonomy_name ) ) :

        wp_redirect( site_url( str_replace($taxonomy_slug, '', $_SERVER['REQUEST_URI']) ), 301 );
        exit();

    endif;

}

add_action( 'pre_get_posts', 'customize_search_query' );
function customize_search_query( WP_Query $wp_query ) {
    if ( $wp_query->is_main_query() && ! $wp_query->is_admin() && $wp_query->is_tax( 'category_review' ) ) {
        $wp_query->set( 'meta_query', array(
            'relation' => 'OR',
            array(
                'key' => 'rmp_rating_val_sum',
                'compare' => 'EXISTS'
            ),
            array(
                'key' => 'rmp_rating_val_sum',
                'compare' => 'NOT EXISTS'
            ),
        ) );
        $wp_query->set( 'orderby', 'meta_value' );
        $wp_query->set( 'order', 'DESC' );
    }
}

$use_prg = new prg_pattern();
class prg_pattern {
    public function __construct() {
        add_action( 'template_redirect', array( $this, 'prg_get_and_redirect' ) );
        add_shortcode( 'prgpattern', array( $this, 'prg_pattern_form' ) );
    }

    public function prg_pattern_form( $atts ){
        $atts = shortcode_atts(
            array(
                'slug'   => 'noFoo',
                'title'  => 'noBob',
                'extern' => 'false',
                'class'  => ''
            ), $atts, 'prgpattern' );

        if ( $atts['extern'] == 'true' ) {
            $redirect_slug = esc_url( $atts['slug'] );
        } else {
            $redirect_slug = esc_url( home_url() . '/' . strtolower( $atts['slug'] ) );
        }

        ob_start();?>
        <form method="POST" target="_blank">
            <button class="<?php echo $atts['class'] ? $atts['class'] : ''; ?>" class="noLink" type="submit" name="prgpattern" value="<?php echo $redirect_slug; ?>">
                <span><?php echo $atts['title']; ?></span>
            </button>
        </form>
        <?php
        return ob_get_clean();
    }


    public function prg_get_and_redirect(){
        if ( isset( $_POST['prgpattern'] ) ) {
            $slug = esc_url( $_POST['prgpattern'] );
            wp_redirect( $slug );
            exit();
        }
    }
}

