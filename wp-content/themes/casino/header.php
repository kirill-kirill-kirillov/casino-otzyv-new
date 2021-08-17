<?php
$site_options         = new SiteOptions();
$logo                 = $site_options->get_field( 'logo' );
$menu                 = $site_options->get_field( 'menu' );
$paged                = $site_options->get_field( 'paged' );
$url_without_page_num = $site_options->get_current_url_without_page_num();?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php if ( $paged > 1 ) : ?>
        <meta name="robots" content="index,follow">
    <?php endif; ?>
    <link rel="canonical" href="<?php echo $url_without_page_num; ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="page-wrapper">



    <header class="header" id="header">
        <div class="container">
            <?php if ( $logo ) : ?>
                <div class="logo header__logo">
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
                <ul class="menu header__menu">
                    <?php foreach ( $menu as $menu_item ) : ?>
                        <?php $submenu = $menu_item['submenu'] ? $menu_item['submenu'] : ''; ?>
                        <?php if ( $menu_item['link'] ) : ?>
                            <li>
                                <a href="<?php echo $menu_item['link']['url']; ?>"<?php echo $menu_item['link']['target'] ? ' target="' . $menu_item['link']['target'] . '"' : '' ?>>
                                    <?php if ( $menu_item['icon'] ) : ?>
                                        <img src="<?php echo esc_url( $menu_item['icon'] ); ?>" alt="">
                                    <?php endif; ?>
                                    <span><?php echo esc_html( $menu_item['link']['title'] ); ?></span>
                                </a>

                                <?php if ( $submenu ) : ?>
                                    <img class="submenu-arrow" src="<?php bloginfo( 'template_directory' ); ?>/images/down-arrow.svg" alt="">
                                <?php endif; ?>

                                <?php if ( $submenu ) : ?>
                                    <ul class="submenu">
                                        <?php foreach ( $submenu as $submenu_item ) : ?>
                                            <li>
                                                <a href="<?php echo $submenu_item['link']['url']; ?>"<?php echo $submenu_item['link']['target'] ? ' target="' . $submenu_item['link']['target'] . '"' : '' ?>>
                                                    <span><?php echo esc_html( $submenu_item['link']['title'] ); ?></span>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="mobile-open">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>
