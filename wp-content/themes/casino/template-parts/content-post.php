<?php

if ( isset( $args ) ) {
    if ( isset( $args['post_id'] ) ) {
        $post_id = $args['post_id'];
    } else {
        $post_id = get_the_ID();
    }
}

$title     = get_the_title( $post_id );
$permalink = get_the_permalink( $post_id );
$excerpt   = get_the_excerpt( $post_id );
$date      = get_the_date( 'd/m/Y', $post_id );
$thumbnail = get_the_post_thumbnail_url( $post_id, 'post-teaser' ) ? get_the_post_thumbnail_url( $post_id, 'post-teaser' ) : ''; ?>

<div class="blog-block__item">
    <?php if ( $thumbnail ) : ?>
        <img src="<?php echo esc_url( $thumbnail ); ?>" alt="" class="blog-block__item-thumbnail">
    <?php endif; ?>

    <div class="blog-block__item-main">
        <div class="blog-block__item-title"><?php echo $title; ?></div>
        <?php if ( $excerpt ) : ?>
            <div class="blog-block__item-excerpt"><?php echo esc_html( $excerpt ); ?></div>
        <?php endif; ?>
        <div class="blog-block__item-bottom">
            <a href="<?php echo esc_url( $permalink ); ?>" class="blog-block__item-more">
                <div class="blog-block__item-more-button">
                    <span></span>
                    <span></span>
                </div>
                Читать полностью
            </a>
            <div class="blog-block__item-date"><?php echo $date; ?></div>
        </div>
    </div>
</div>
