<?php

if ( isset( $args ) ) {
    if ( isset( $args['post_id'] ) ) {
        $post_id = $args['post_id'];
    } else {
        $post_id = get_the_ID();
    }
}

$id_comment        = get_field( 'id_comment', $post_id ) ? get_field( 'id_comment', $post_id ) : '';
$permalink         = get_the_permalink( $post_id );
$permalink_comment = $id_comment ? get_the_permalink( $id_comment ) : '';
$thumbnail         = get_the_post_thumbnail_url( $post_id, 'casino-review-teaser' ) ? get_the_post_thumbnail_url( $post_id, 'casino-review-teaser' ) : '';
$title             = get_field( 'title', $post_id ) ? get_field( 'title', $post_id ) : '';
$trust_players     = get_field( 'trust_players', $post_id ) ? get_field( 'trust_players', $post_id ) : '';
$bonuses           = get_field( 'bonuses', $post_id ) ? get_field( 'bonuses', $post_id ) : '';
$pros              = get_field( 'pros', $post_id ) ? get_field( 'pros', $post_id ) : '';
$link              = get_field( 'link', $post_id ) ? get_field( 'link', $post_id ) : '';
$top_rated_posts   = rmp_get_top_rated_posts( 3 );
$post_top          = false;

foreach ( $top_rated_posts as $key => $top_rated_post ) {
    if ( $top_rated_post['postID'] === $post_id ) {
        $post_top     = true;
        $post_top_key = ++$key;
    }
} ?>

<div class="rating-casino__item<?php echo $post_top ? ' rating-casino__item_top' : ''; ?>">
    <?php if ( $post_top ) : ?>
        <div class="rating-casino__item-top"><span>Top <?php echo $post_top_key; ?></span></div>
    <?php endif; ?>

    <div class="rating-casino__item-main">
        <div class="rating-casino__item-left">
            <?php if ( $thumbnail ) : ?>
                <img src="<?php echo esc_url( $thumbnail ); ?>" alt="" class="rating-casino__item-thumbnail">
            <?php endif; ?>

            <div class="rating-casino__item-left-block">
                <?php if ( $title ) : ?>
                    <div class="rating-casino__item-title"><?php echo esc_html( $title ); ?></div>
                <?php endif; ?>
                <div class="rating-casino__item-rating">
                    <img src="<?php bloginfo( 'template_directory' ); ?>/images/star-<?php echo (int) round( rmp_get_avg_rating( $post_id ), PHP_ROUND_HALF_DOWN ); ?>.svg" alt="">
                    <?php $rmp_avg_rating = get_post_meta( $post_id, 'rmp_avg_rating', true ) ? get_post_meta( $post_id, 'rmp_avg_rating', true ) : 0; ?>
                    <span><span><?php echo $rmp_avg_rating !== 0 ? number_format( $rmp_avg_rating, 1, '.', '' ) : 0; ?></span>/5</span>
                </div>
            </div>
        </div>
        <div class="rating-casino__item-center">
            <div class="rating-casino__item-center-top">
                <?php if ( $trust_players ) : ?>
                    <div class="trust-players">
                        <div class="trust-players__main">
                            <div class="trust-players__title">Доверие игроков</div>
                            <div class="trust-players__value"><span><?php echo $trust_players; ?></span>%</div>
                        </div>
                        <div class="trust-players__line">
                            <span></span>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="rating-view">
                    <div class="rating-view__stars">
                        <?php echo rmp_get_visual_rating( $post_id ); ?>
                    </div>
                    <div class="rating-view__number">
                        <span><?php echo rmp_get_avg_rating( $post_id ); ?></span>/5
                    </div>
                </div>
            </div>
            <div class="rating-casino__item-center-main">
                <?php if ( $bonuses ) : ?>
                    <div class="rating-casino__item-bonuses">
                        <div class="rating-casino__item-bonuses-title">Бонусы:</div>
                        <ul>
                            <?php foreach ( $bonuses as $bonus ) : ?>
                                <li><span><?php echo $bonus['bonus'] ? $bonus['bonus'] : ''; ?>%</span><?php echo $bonus['title'] ? $bonus['title'] : ''; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ( $pros ) : ?>
                    <ul class="pros-casino">
                        <?php foreach ( $pros as $plus ) : ?>
                            <?php if ( $plus['text'] ) : ?>
                                <li><img src="<?php bloginfo( 'template_directory' ); ?>/images/plus.svg" alt=""><span><?php echo esc_html( $plus['text'] ); ?></span></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
        <div class="rating-casino__item-right">
            <?php if ( $link ) : ?>
                <?php echo do_shortcode('[prgpattern slug="' . esc_url( $link ) . '" title="Играть" extern="true" class="form-red-btn form-red-btn_rating-casino"]'); ?>
            <?php endif; ?>

            <a href="<?php echo $permalink; ?>" class="btn btn_blue"><span>Полный обзор</span></a>

            <?php if ( $permalink_comment ) : ?>
                <a href="<?php echo $permalink_comment; ?>" class="btn btn_green"><span>Отзывы</span></a>
            <?php endif; ?>
        </div>
    </div>
</div>
