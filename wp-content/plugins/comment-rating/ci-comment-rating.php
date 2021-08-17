<?php
/*
Plugin Name: CI Comment Rating
Description: Adds a star rating system to WordPress comments
Version: 1.0.0

*/

//Enqueue the plugin's styles.
add_action( 'wp_enqueue_scripts', 'ci_comment_rating_styles' );
function ci_comment_rating_styles() {

	wp_register_style( 'ci-comment-rating-styles', plugins_url( '/', __FILE__ ) . 'assets/style.css' );

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'ci-comment-rating-styles' );

	wp_enqueue_script( 'mainjs', plugins_url( '/', __FILE__ ) . 'assets/main.js', array('jquery') );


}

//Create the rating interface.
add_action( 'comment_form_logged_in_after', 'ci_comment_rating_rating_field' );
add_action( 'comment_form_after_fields', 'ci_comment_rating_rating_field' );
function ci_comment_rating_rating_field() {
	?>

    <?php if ( get_post_type( get_the_ID() ) !== 'post' ) : ?>
        <div class="comment-rating-wrapper">
            <?php $post_id = get_the_ID(); ?>
            <?php if ( ! isset( $_COOKIE[$post_id] ) ) : ?>
                <span class="rating-container">
                    <?php for ( $i = 5; $i >= 1; $i -- ) : ?>
                        <input type="radio" id="rating-<?php echo esc_attr( $i ); ?>" name="rating" value="<?php echo esc_attr( $i ); ?>"/>
                        <label for="rating-<?php echo esc_attr( $i ); ?>"></label>
                    <?php endfor; ?>
                    <!--<input type="radio" id="rating-0" class="star-cb-clear" name="rating" value="0"/><label for="rating-0"></label>-->
                </span>
            <?php else: ?>
                <ul class="rmp-rating-widget__icons-list js-rmp-rating-icons-list">
                    <?php for ( $icons_count = 0; $icons_count < 5; $icons_count++ ): ?>
                        <li class="rmp-rating-widget__icons-list__icon js-rmp-rating-item" data-value="<?php echo $icons_count + 1 ?>">
                            <i class="js-rmp-rating-icon rmp-icon rmp-icon--ratings rmp-icon--star<?php echo $icons_count < (int) $_COOKIE[$post_id] ? ' rmp-icon--full-highlight' : ''; ?>"></i>
                        </li>
                    <?php endfor; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endif; ?>

	<?php
}


// Add to the admin_init function
//add_meta_box('comment_rates', __('Extra Arguments'), 'comment_rates_metabox', 'comment', 'normal');


add_action( 'admin_menu', 'misha_add_metabox' );

function misha_add_metabox() {

	add_meta_box(
		'comment_rates', // metabox ID
		'Comment rating', // title
		'comment_rates_metabox', // callback function
		'comment', // post type or post types in array
		'normal', // position (normal, side, advanced)
		'default' // priority (default, low, high, core)
	);

}


function comment_rates_metabox( $comment ) {

	$comment_rating = get_comment_meta( $comment->comment_ID, 'rating', true );

	?>
    <table class="form-table editcomment comment_xtra">
        <tbody>
        <tr valign="top">
            <td class="first"><?php _e( 'Comment Rating:' ); ?></td>
            <td><input type="number" min="1" max="5" id="comment_rating" name="comment_rating" size="20" class="code"
                       value="<?php echo esc_attr( $comment_rating ); ?>" tabindex="1"/></td>
        </tr>

        </tbody>
    </table>
	<?php
}


add_filter( 'comment_edit_redirect', 'save_comment_wpse_82317', 10, 2 );


function save_comment_wpse_82317( $location, $comment_id ) {
	// Not allowed, return regular value without updating meta
	if ( ! wp_verify_nonce( $_POST['noncename_wpse_82317'], plugin_basename( __FILE__ ) )
	     && ! isset( $_POST['comment_rating'] )
	) {
		return $location;
	}

	// Update meta
	update_comment_meta(
		$comment_id,
		'rating',
		sanitize_text_field( $_POST['comment_rating'] )
	);

	// Return regular value after updating
	return $location;
}

//Save the rating submitted by the user.
add_action( 'comment_post', 'ci_comment_rating_save_comment_rating' );
function ci_comment_rating_save_comment_rating( $comment_id ) {
	if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) ) {
		$rating = intval( $_POST['rating'] );
	}
	add_comment_meta( $comment_id, 'rating', $rating );
}


//Display the rating on a submitted comment.
add_filter( 'comment_text', 'ci_comment_rating_display_rating' );
function ci_comment_rating_display_rating( $comment_text ) {

	if ( is_admin() ) {

		if ( $rating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
			$stars = '<div class="stars">';
			for ( $i = 1; $i <= $rating; $i ++ ) {
				$stars .= '<span class="dashicons dashicons-star-filled"></span>';
			}
			$stars        .= '</div>';
			$comment_text = $comment_text . $stars;

			return $comment_text;
		} else {
			return $comment_text;
		}
	} else {
		return $comment_text;
    }
}


function do_my_hook( $comment ) {

	if ( (int) $rating = get_comment_meta( $comment->comment_ID, 'rating', true ) ) {

		$rating = (int) $rating;
		$stars  = '<div class="stars"><span class="comm-rating-title">Оценка:</span>';

		for ( $i = 1; $i <= 5; $i ++ ) {
			if($i <= $rating){
				$stars .= ' <img src="'.get_template_directory_uri().'/img/star.svg" alt="star" class="comm-star-rating">';
			} else {
				$stars .= ' <img src="'.get_template_directory_uri().'/img/star-empty.svg" alt="star" class="comm-star-rating">';
			}
		}
		$stars .= '</div>';

		echo $stars;
	} else {
		echo '';
	}

}

// Регистрируем хук через
// add_action( $tag, $function_to_add, $priority, $accepted_args );
add_action( 'comment_stars_rating', 'do_my_hook', 10, 1 );


//Get the average rating of a post.
function ci_comment_rating_get_average_ratings( $id ) {
	$comments = get_approved_comments( $id );

	if ( $comments ) {
		$i     = 0;
		$total = 0;
		foreach ( $comments as $comment ) {
			$rate = get_comment_meta( $comment->comment_ID, 'rating', true );
			if ( isset( $rate ) && '' !== $rate ) {
				$i ++;
				$total += $rate;
			}
		}

		if ( 0 === $i ) {
			return false;
		} else {
			return round( $total / $i, 1 );
		}
	} else {
		return false;
	}
}

//Display the average rating above the content.
//add_filter( 'the_content', 'ci_comment_rating_display_average_rating' );
function ci_comment_rating_display_average_rating( $content ) {

	global $post;

	if ( false === ci_comment_rating_get_average_ratings( $post->ID ) ) {
		return $content;
	}

	$stars   = '';
	$average = ci_comment_rating_get_average_ratings( $post->ID );

	for ( $i = 1; $i <= $average + 1; $i ++ ) {

		$width = intval( $i - $average > 0 ? 20 - ( ( $i - $average ) * 20 ) : 20 );

		if ( 0 === $width ) {
			continue;
		}

		$stars .= '<span style="overflow:hidden; width:' . $width . 'px" class="dashicons dashicons-star-filled"></span>';

		if ( $i - $average > 0 ) {
			$stars .= '<span style="overflow:hidden; position:relative; left:-' . $width . 'px;" class="dashicons dashicons-star-empty"></span>';
		}
	}

	$custom_content = '<p class="average-rating">This post\'s average rating is: ' . $average . ' ' . $stars . '</p>';
	$custom_content .= $content;

	return $custom_content;
}