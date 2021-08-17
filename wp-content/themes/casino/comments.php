<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package casino
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}

$comments_count = get_comments_number();
?>

<div id="comments" class="comments comments-area">

    <?php
    // You can start editing here -- including this comment!
    if ( have_comments() ) :
        ?>

        <?php //the_comments_navigation(); ?>

        <div class="comments__list">
            <?php
            wp_list_comments(
                array(
                    'style'      => 'div',
                    'short_ping' => true,
                    'callback'   => 'casino_comment'
                )
            );
            ?>
        </div><!-- .comment-list -->

        <?php
        //the_comments_navigation();

        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() ) :
            ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'casino' ); ?></p>
        <?php
        endif;

    endif; // Check for have_comments().

    $fields = array(
        'author' => sprintf(
            '<div class="comment-form__row"><p class="comment-form-author">%s %s</p>',
            sprintf(
                '<label for="author">%s%s</label>',
                __( 'Как вас зовут?' ),
                ( ' <span class="required">*</span>' )
            ),
            sprintf(
                '<input id="author" name="author" type="text" value="%s" size="30" maxlength="245"%s />',
                esc_attr( $commenter['comment_author'] ),
                $html_req
            )
        ),
        'email'  => sprintf(
            '<p class="comment-form-email">%s %s</p></div>',
            sprintf(
                '<label for="email">%s%s</label>',
                __( 'Ваша электронная почта' ),
                ( $req ? ' <span class="required">*</span>' : '' )
            ),
            sprintf(
                '<input id="email" name="email" %s value="%s" size="30" maxlength="100" aria-describedby="email-notes"%s />',
                ( $html5 ? 'type="email"' : 'type="text"' ),
                esc_attr( $commenter['comment_author_email'] ),
                $html_req
            )
        ),
    );

    comment_form( [
        'fields'               => $fields,
        'comment_field'        => '<p class="comment-form-comment">
            <label for="comment">' . _x( 'Ваш отзыв', 'noun' ) . '</label>
            <textarea id="comment" name="comment" cols="45" rows="8"  aria-required="true" required="required"></textarea>
        </p>',
        'logged_in_as'         => '',
        'title_reply'          => get_post_type( get_the_ID() ) !== 'post' ? __( 'Оставить отзыв' ) : __( 'Оставить комментарий' ),
        'title_reply_before'   => '<div id="reply-title" class="comment-reply-title"><span>',
        'title_reply_after'    => '</div>',
        'cancel_reply_before'  => '</span> <small>',
        'cancel_reply_after'   => '</small>',
        'cancel_reply_link'    => __( 'Отменить' ),
        'label_submit'         => __( 'Ответить' ),
        'comment_notes_before' => '',
    ] );
    ?>

</div><!-- #comments -->

<?php function casino_comment( $comment, $args, $depth ) {
    $comment_id     = (int) $comment->comment_ID;
    $comment_geo    = get_field( 'geo', $comment ) ? get_field( 'geo', $comment ) : '';
    $comment_parent = $comment->comment_parent ? (int) $comment->comment_parent : '';
    $author_name    = get_comment_author( $comment_id );
    $post_id        = (int) $comment->comment_post_ID;
    $stars_comments = get_post_meta( $post_id, 'stars_comments', true ) ? get_post_meta( $post_id, 'stars_comments', true ) : array();
    $comment_author = $comment->comment_author;
    $user = get_user_by( 'login', $comment_author );
    $user_id = (int) $user->data->ID;

    $stars_comments_rating = $stars_comments[$user_id] ? $stars_comments[$user_id] : 0;
    /*if ( $stars_comments[$comment_id] || $stars_comments[$comment_parent] ) {
        $stars_comments_rating = $stars_comments[$comment_id] ? $stars_comments[$comment_id] : $stars_comments[$comment_parent];
    }*/

    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }

    $classes = ' ' . comment_class( empty( $args['has_children'] ) ? '' : 'parent', null, null, false );
    ?>

    <<?php echo $tag, $classes; ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) { ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
    } ?>

    <div class="comment__main">
        <div class="comment__header">
            <?php if ( $args['avatar_size'] != 0 ) {
                echo get_avatar( $comment, 62 );
            } ?>

            <div class="comment__header-center">
                <div class="comment__author-name"><?php echo $author_name; ?></div>
                <?php if ( $comment_geo ) : ?>
                    <div class="comment__geo">
                        <img src="<?php bloginfo( 'template_directory' ); ?>/images/geo.svg" alt="">
                        <span><?php echo esc_html( $comment_geo ); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="comment__header-right">
                <?php if ( ! $comment_parent ) : ?>
                    <div class="comment-rating-wrapper">
                        <ul class="rmp-rating-widget__icons-list js-rmp-rating-icons-list">
                            <?php if ( $stars_comments_rating ) : ?>
                                <?php for ( $icons_count = 0; $icons_count < 5; $icons_count++ ): ?>
                                    <li class="rmp-rating-widget__icons-list__icon js-rmp-rating-item" data-value="<?php echo $icons_count + 1 ?>">
                                        <i class="js-rmp-rating-icon rmp-icon rmp-icon--ratings rmp-icon--star<?php echo $icons_count < (int) $stars_comments_rating ? ' rmp-icon--full-highlight' : ''; ?>"></i>
                                    </li>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="rating-casino__item-rating rating-casino__item-rating-comment-mobile">
                        <img src="<?php bloginfo( 'template_directory' ); ?>/images/star-<?php echo $stars_comments_rating; ?>.svg" alt="">
                        <span><span><?php echo $stars_comments_rating !== 0 ? number_format( $stars_comments_rating, 1, '.', '' ) : 0; ?></span></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ( $comment->comment_approved == '0' ) { ?>
            <em class="comment-awaiting-moderation">
                <?php _e( 'Your comment is awaiting moderation.' ); ?>
            </em><br/>
        <?php } ?>

        <div class="comment__text">
            <?php comment_text(); ?>
        </div>

        <!--<div class="comment-meta commentmetadata">
        <a href="<?php /*echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); */?>">
            <?php
        /*            printf(
                        __( '%1$s at %2$s' ),
                        get_comment_date(),
                        get_comment_time()
                    ); */?>
        </a>

        <?php /*edit_comment_link( __( '(Edit)' ), '  ', '' ); */?>
    </div>-->

        <div class="comment__reply">
            <?php
            comment_reply_link(
                array_merge(
                    $args,
                    array(
                        'add_below' => $add_below,
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth']
                    )
                )
            ); ?>
        </div>
    </div>

    <?php if ( 'div' != $args['style'] ) { ?>
        </div>
    <?php }
} ?>