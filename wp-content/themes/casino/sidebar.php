<div class="page-content-main__right">
    <?php
    $query = new WP_Query( [
        'post_type'      => 'casino-review',
        'posts_per_page' => 10,
        'meta_key'       => 'rmp_avg_rating',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC'
        /*'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'rmp_rating_val_sum',
                'compare' => 'EXISTS'
            ),
            array(
                'key' => 'rmp_rating_val_sum',
                'compare' => 'NOT EXISTS'
            ),
        ),
        'orderby' => 'meta_value',
        'order'   => 'DESC'*/
    ] );
    $i = 1; ?>

    <?php if ( $query->have_posts() ) : ?>
        <div class="top-10-casino">
            <div class="top-10-casino__title">Топ 10 казино</div>
            <div class="top-10-casino__items">
                <div class="top-10-casino__items-block1">
                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                        <?php get_template_part( 'template-parts/content-top-10', 'casino', [ 'i' => $i, 'query' => $query ] ); ?>
                        <?php $i++; endwhile; ?>
                    <?php wp_reset_postdata(); ?>
            </div>
        </div>
    <?php endif; wp_reset_query(); ?>
</div>