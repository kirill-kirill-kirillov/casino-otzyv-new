        <?php
        $site_options = new SiteOptions();
        $logo         = $site_options->get_field( 'logo' );
        $menu         = $site_options->get_field( 'menu' ); ?>

        <footer class="footer">
            <div class="container">
                <div class="footer__main">
                    <?php if ( $logo ) : ?>
                        <div class="logo footer__logo">
                            <?php if ( is_front_page() ) : ?>
                                <img src="<?php echo $logo; ?>" alt="">
                            <?php else: ?>
                                <a href="/">
                                    <img src="<?php echo $logo; ?>" alt="">
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( $menu ) : ?>
                        <ul class="menu footer__menu">
                            <?php foreach ( $menu as $menu_item ) : ?>
                                <?php if ( $menu_item['link'] ) : ?>
                                    <li>
                                        <a href="<?php echo $menu_item['link']['url']; ?>"<?php echo $menu_item['link']['target'] ? ' target="' . $menu_item['link']['target'] . '"' : '' ?>>
                                            <?php if ( $menu_item['icon'] ) : ?>
                                                <img src="<?php echo esc_url( $menu_item['icon'] ); ?>" alt="">
                                            <?php endif; ?>
                                            <span><?php echo esc_html( $menu_item['link']['title'] ); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <a href="#header" class="footer__scroll-top scroll-btn">
                        <img src="<?php bloginfo( 'template_directory' ); ?>/images/scroll-top.svg" alt="">
                    </a>
                </div>

                <hr>

                <div class="footer__bottom">
                    <div class="footer__copy">Copyright <?php echo date( 'Y' ); ?></div>
                </div>
            </div>
        </footer>

    </div>

    <?php wp_footer(); ?>
</body>
</html>
