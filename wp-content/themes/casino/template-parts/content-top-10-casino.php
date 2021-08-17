<?php

if ( isset( $args ) ) {
    if ( isset( $args['post_id'] ) ) {
        $post_id = $args['post_id'];
    } else {
        $post_id = get_the_ID();
    }
    if ( isset( $args['i'] ) ) {
        $i = $args['i'];
    }

    if ( isset( $args['query'] ) ) {
        $query = $args['query'];
    }
}

$id_comment        = get_field( 'id_comment', $post_id ) ? get_field( 'id_comment', $post_id ) : '';
$permalink         = get_the_permalink( $post_id );
$permalink_comment = $id_comment ? get_the_permalink( $id_comment ) : '';
$thumbnail         = get_the_post_thumbnail_url( $post_id, 'top-10-teaser' ) ? get_the_post_thumbnail_url( $post_id, 'top-10-teaser' ) : '';
$title             = get_field( 'title', $post_id ) ? get_field( 'title', $post_id ) : '';
$bonuses           = get_field( 'bonuses', $post_id ) ? get_field( 'bonuses', $post_id ) : '';
$link              = get_field( 'link', $post_id ) ? get_field( 'link', $post_id ) : '';
$top_rated_posts   = rmp_get_top_rated_posts( 3 );
$post_top          = false;

foreach ( $top_rated_posts as $key => $top_rated_post ) {
    if ( $top_rated_post['postID'] === $post_id ) {
        $post_top     = true;
        $post_top_key = ++$key;
    }
} ?>

    <div class="top-10-casino__item<?php echo $post_top ? ' top-10-casino__item_top' : ''; ?>">
        <div class="top-10-casino__item-main">
            <div class="top-10-casino__item-top"><span><?php echo $post_top_key ? $post_top_key : $i; ?></span></div>
            <a href="<?php echo esc_url( $permalink ); ?>" class="top-10-casino__item-center">
                <?php if ( $thumbnail ) : ?>
                    <img src="<?php echo esc_url( $thumbnail ); ?>" alt="" class="top-10-casino__item-thumbnail">
                <?php endif; ?>
                <div class="top-10-casino__item-center-main">
                    <?php if ( $title ) : ?>
                        <div class="top-10-casino__item-title"><?php echo esc_html( $title ); ?></div>
                    <?php endif; ?>
                    <?php if ( $bonuses[0] ) : ?>
                        <div class="top-10-casino__item-bonus"><?php echo $bonuses[0]['bonus'] ? $bonuses[0]['bonus'] . '%' : ''; echo $bonuses[0]['title'] ? ' ' . $bonuses[0]['title'] : ''; ?></div>
                    <?php endif; ?>
                </div>
            </a>
            <div class="top-10-casino__item-rating">
                <?php $rmp_avg_rating = floatval( rmp_get_avg_rating( $post_id ) ); ?>
                <img src="<?php bloginfo( 'template_directory' ); ?>/images/star-<?php echo(int) round( $rmp_avg_rating, PHP_ROUND_HALF_DOWN ); ?>.svg" alt="">
                <span><?php echo $rmp_avg_rating !== 0 ? number_format( $rmp_avg_rating, 1, '.', '' ) : 0; ?></span>
            </div>
        </div>

        <?php if ( $i <= 3 ) : ?>
            <div class="top-10-casino__item-buttons">
                <?php if ( $link ) : ?>
                    <?php echo do_shortcode('[prgpattern slug="' . esc_url( $link ) . '" title="Играть" extern="true" class="form-red-btn form-red-btn_top-10-casino"]'); ?>
                <?php endif; ?>

                <a href="<?php echo $permalink; ?>" class="btn btn_blue"><span>Обзор</span></a>

                <?php if ( $permalink_comment ) : ?>
                    <a href="<?php echo $permalink_comment; ?>" class="btn btn_green"><span>Отзывы</span></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php echo $i === 4 ? '</div><div class="top-10-casino__items-block2">': '';?>
<?php echo $i === $query->found_posts ? '</div>' : ''; ?>
