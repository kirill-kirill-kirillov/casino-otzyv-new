<?php get_header(); ?>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
        $page_id = get_the_ID(); ?>

        <div class="page-content">
            <div class="container">

                <div class="page-content-main">
                    <div class="page-content-main__left">

                        <h1 class="page-title"><?php the_title(); ?></h1>

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
