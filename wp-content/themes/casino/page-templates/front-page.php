<?php
/*
 * Template Name: Главная
 */ ?>

<?php get_header(); ?>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
        $page_id = get_the_ID(); ?>

        <div class="page-content">
            <div class="container">

                <div class="page-content-main">
                    <div class="page-content-main__left">

                        <h1 class="page-title"><?php the_title(); ?></h1>

                        <?php
                        $site_options = new SiteOptions();
                        $paged        = $site_options->get_field( 'paged' );

                        $query = new WP_Query( [
                            'post_type'      => 'casino-review',
                            'posts_per_page' => 8,
                            'paged'          => $paged,
                            'meta_key'       => 'rmp_avg_rating',
                            'orderby'        => 'meta_value_num',
                            'order'          => 'DESC'
                        ] ); ?>

                        <?php if ( $query->have_posts() ) : ?>
                            <div class="rating-casino">
                                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                    <?php get_template_part( 'template-parts/content', 'casino' ); ?>
                                <?php endwhile; ?>
                                <?php wp_reset_postdata(); ?>

                                <div class="pagination">
                                    <?php echo paginate_links(
                                        array(
                                            /*'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                                            'format'    => 'paged=%#%',*/
                                            'current'   => $paged,
                                            'total'     => $query->max_num_pages,
                                            'next_text' => '<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M32 8C32 3.58172 28.4183 0 24 0H0V24C0 28.4183 3.58172 32 8 32H32V8Z" fill="#2E955D"/>
<path d="M24.5303 15.4697C24.8232 15.7626 24.8232 16.2374 24.5303 16.5303L19.7574 21.3033C19.4645 21.5962 18.9896 21.5962 18.6967 21.3033C18.4038 21.0104 18.4038 20.5355 18.6967 20.2426L22.9393 16L18.6967 11.7574C18.4038 11.4645 18.4038 10.9896 18.6967 10.6967C18.9896 10.4038 19.4645 10.4038 19.7574 10.6967L24.5303 15.4697ZM8 15.25L24 15.25V16.75L8 16.75V15.25Z" fill="white"/>
</svg>
',
                                            'prev_text' => '<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0 8C0 3.58172 3.58172 0 8 0H32V24C32 28.4183 28.4183 32 24 32H0V8Z" fill="#2E955D"/>
<path d="M7.46967 15.4697C7.17678 15.7626 7.17678 16.2374 7.46967 16.5303L12.2426 21.3033C12.5355 21.5962 13.0104 21.5962 13.3033 21.3033C13.5962 21.0104 13.5962 20.5355 13.3033 20.2426L9.06066 16L13.3033 11.7574C13.5962 11.4645 13.5962 10.9896 13.3033 10.6967C13.0104 10.4038 12.5355 10.4038 12.2426 10.6967L7.46967 15.4697ZM24 15.25L8 15.25V16.75L24 16.75V15.25Z" fill="white"/>
</svg>',
                                        )
                                    ); ?>
                                </div>

                            </div>
                        <?php endif; wp_reset_query(); ?>

                        <div class="page-content-main__content">
                            <div class="content-style">
                                <?php the_content(); ?>
                            </div>
                        </div>

                    </div>
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    <?php endwhile; endif; ?>

<?php get_footer(); ?>
