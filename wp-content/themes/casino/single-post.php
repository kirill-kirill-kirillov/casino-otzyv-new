<?php get_header(); ?>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
        $page_id = get_the_ID(); ?>

        <div class="page-content page-content_bread">
            <div class="container">

                <div class="breadcrumbs">
                    <a href="/">Рейтинг казино</a>
                    <img src="<?php bloginfo( 'template_directory' ); ?>/images/breadcrumb.svg" alt="">
                    <a href="/blog/">Блог</a>
                    <img src="<?php bloginfo( 'template_directory' ); ?>/images/breadcrumb.svg" alt="">
                    <span><?php the_title(); ?></span>
                </div>

                <div class="page-content-main">
                    <div class="page-content-main__left">

                        <h1 class="page-title"><?php the_title(); ?></h1>

                        <div class="page-content-main__content">
                            <div class="content-style">
                                <?php the_content(); ?>
                            </div>

                            <?php if ( comments_open() || get_comments_number() ) {
                                comments_template();
                            } ?>
                        </div>

                    </div>
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    <?php endwhile; endif; ?>

<?php get_footer(); ?>
