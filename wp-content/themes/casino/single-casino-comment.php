<?php get_header(); ?>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
        $post_id           = get_the_ID();
        $top_rated_posts   = rmp_get_top_rated_posts( 3 );
        $id_review         = get_field( 'id_review', $post_id ) ? (int) get_field( 'id_review', $post_id ) : '';
        $permalink_review  = $id_review ? get_the_permalink( $id_review ) : '';
        $thumbnail         = get_the_post_thumbnail_url( $id_review, 'casino-review-full' ) ? get_the_post_thumbnail_url( $id_review, 'casino-review-full' ) : '';
        $title             = get_field( 'title', $id_review ) ? get_field( 'title', $id_review ) : '';
        $trust_players     = get_field( 'trust_players', $id_review ) ? get_field( 'trust_players', $id_review ) : '';
        $bonuses           = get_field( 'bonuses', $id_review ) ? get_field( 'bonuses', $id_review ) : '';
        $pros              = get_field( 'pros', $id_review ) ? get_field( 'pros', $id_review ) : '';
        $menuses           = get_field( 'menuses', $id_review ) ? get_field( 'menuses', $id_review ) : '';
        $link              = get_field( 'link', $id_review ) ? get_field( 'link', $id_review ) : '';
        $lic               = get_field( 'lic', $id_review ) ? get_field( 'lic', $id_review ) : '';
        $time              = get_field( 'time', $id_review ) ? get_field( 'time', $id_review ) : '';
        $limit             = get_field( 'limit', $id_review ) ? get_field( 'limit', $id_review ) : '';
        $dep               = get_field( 'dep', $id_review ) ? get_field( 'dep', $id_review ) : '';
        $ver               = get_field( 'ver', $id_review ) ? get_field( 'ver', $id_review ) : '';
        $tip_casino        = get_field( 'tip_casino', $id_review ) ? get_field( 'tip_casino', $id_review ) : '';
        $date              = get_field( 'date', $id_review ) ? get_field( 'date', $id_review ) : '';
        $site              = get_field( 'site', $id_review ) ? get_field( 'site', $id_review ) : '';
        $phone             = get_field( 'phone', $id_review ) ? get_field( 'phone', $id_review ) : '';
        $mail              = get_field( 'mail', $id_review ) ? get_field( 'mail', $id_review ) : '';
        $djeck             = get_field( 'djeck', $id_review ) ? get_field( 'djeck', $id_review ) : '';
        $return_to_player  = get_field( 'return_to_player', $id_review ) ? get_field( 'return_to_player', $id_review ) : '';
        $speed             = get_field( 'speed', $id_review ) ? get_field( 'speed', $id_review ) : '';
        $post_top          = false;

        foreach ( $top_rated_posts as $key => $top_rated_post ) {
            if ( $top_rated_post['postID'] === $id_review ) {
                $post_top     = true;
                $post_top_key = ++$key;
            }
        } ?>

        <div class="page-content page-content_bread">
            <div class="container">

                <div class="breadcrumbs">
                    <a href="/">Рейтинг казино</a>
                    <img src="<?php bloginfo( 'template_directory' ); ?>/images/breadcrumb.svg" alt="">
                    <span><?php the_title(); ?></span>
                </div>

                <div class="sidebar-top-mobile">
                    <?php require get_template_directory() . '/sidebar.php'; ?>
                </div>

                <div class="review-header review-header-mobile<?php echo $post_top ? ' review-header_top' : ''; ?>">
                    <?php if ( $post_top ) : ?>
                        <div class="review-header-top">
                            <span>Top <?php echo $post_top_key; ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="review-header-mobile__top">
                        <?php if ( $thumbnail ) : ?>
                            <img src="<?php echo esc_url( $thumbnail ); ?>" alt="" class="review-header__thumbnail">
                        <?php endif; ?>

                        <div class="review-header__right-top review-header__right-top-mobile">
                            <div class="review-header__votes">
                                <a href="<?php echo $permalink_review; ?>" class="votes-count">
                                    <img src="<?php bloginfo( 'template_directory' ); ?>/images/votes.svg" alt="">
                                    <span><?php echo num_declension( (int) rmp_get_vote_count( $id_review ), [ 'голос', 'голоса', 'голосов' ] ); ?></span>
                                </a>
                            </div>
                            <div class="review-header__reviews">
                                <a href="#comments-block" class="scroll-btn">
                                    <img src="<?php bloginfo( 'template_directory' ); ?>/images/reviews.svg" alt="">
                                    <span><?php echo num_declension( (int) get_comments_number( $post_id ), [ 'отзыв', 'отзыва', 'отзывов' ] ); ?></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php if ( $title ) : ?>
                        <div class="review-header__title"><span><?php echo esc_html( $title ); ?></span></div>
                    <?php endif; ?>

                    <div class="review-header-mobile-center">
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

                        <div class="rating-casino__item-rating">
                            <img src="<?php bloginfo( 'template_directory' ); ?>/images/star-<?php echo (int) round( rmp_get_avg_rating( $id_review ), PHP_ROUND_HALF_DOWN ); ?>.svg" alt="">
                            <?php $rmp_avg_rating = get_post_meta( $id_review, 'rmp_avg_rating', true ) ? get_post_meta( $id_review, 'rmp_avg_rating', true ) : 0; ?>
                            <span><span><?php echo $rmp_avg_rating !== 0 ? number_format( $rmp_avg_rating, 1, '.', '' ) : 0; ?></span></span>
                        </div>
                    </div>

                    <div class="review-header__center review-header__center-mobile">
                        <?php if ( $pros ) : ?>
                            <div class="review-header__pros">
                                <div class="review-header__pros-title">Плюсы</div>
                                <ul class="pros-casino">
                                    <?php foreach ( $pros as $plus ) : ?>
                                        <?php if ( $plus['text'] ) : ?>
                                            <li><img src="<?php bloginfo( 'template_directory' ); ?>/images/plus.svg" alt=""><span><?php echo esc_html( $plus['text'] ); ?></span></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php if ( $menuses ) : ?>
                            <div class="review-header__menuses">
                                <div class="review-header__menuses-title">Минусы</div>
                                <ul class="pros-casino">
                                    <?php foreach ( $menuses as $menus ) : ?>
                                        <?php if ( $menus['text'] ) : ?>
                                            <li><img src="<?php bloginfo( 'template_directory' ); ?>/images/menus.svg" alt=""><span><?php echo esc_html( $menus['text'] ); ?></span></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ( $link ) : ?>
                        <div class="form-red-btn_mobile">
                            <?php echo do_shortcode('[prgpattern slug="' . esc_url( $link ) . '" title="Перейти" extern="true" class="form-red-btn form-red-btn_review-header"]'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="review-header<?php echo $post_top ? ' review-header_top' : ''; ?>">
                    <?php if ( $post_top ) : ?>
                        <div class="review-header-top">
                            <span>Top <?php echo $post_top_key; ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="review-header__left">
                        <?php if ( $thumbnail ) : ?>
                            <div class="review-header__thumbnail__wrap">
                                <img src="<?php echo esc_url( $thumbnail ); ?>" alt="" class="review-header__thumbnail">
                            </div>
                        <?php endif; ?>

                        <div class="review-header__left-block">
                            <?php if ( $title ) : ?>
                                <div class="review-header__title"><span><?php echo esc_html( $title ); ?></span></div>
                            <?php endif; ?>
                            <div class="review-header__left-block-block">
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

                                <div class="review-header__right-top review-header__right-top-mobile">
                                    <div class="review-header__votes">
                                        <a href="<?php echo $permalink_review; ?>" class="votes-count">
                                            <img src="<?php bloginfo( 'template_directory' ); ?>/images/votes.svg" alt="">
                                            <span><?php echo num_declension( (int) rmp_get_vote_count( $id_review ), [ 'голос', 'голоса', 'голосов' ] ); ?></span>
                                        </a>
                                    </div>
                                    <div class="review-header__reviews">
                                        <a href="#comments-block" class="scroll-btn">
                                            <img src="<?php bloginfo( 'template_directory' ); ?>/images/reviews.svg" alt="">
                                            <span><?php echo num_declension( (int) get_comments_number( $post_id ), [ 'отзыв', 'отзыва', 'отзывов' ] ); ?></span>
                                        </a>
                                    </div>
                                </div>

                                <?php echo do_shortcode( '[ratemypost id="' . $id_review . '"]' ); ?>
                            </div>

                            <div class="review-header__center review-header__center-mobile">
                                <?php if ( $pros ) : ?>
                                    <div class="review-header__pros">
                                        <div class="review-header__pros-title">Плюсы</div>
                                        <ul class="pros-casino">
                                            <?php foreach ( $pros as $plus ) : ?>
                                                <?php if ( $plus['text'] ) : ?>
                                                    <li><img src="<?php bloginfo( 'template_directory' ); ?>/images/plus.svg" alt=""><span><?php echo esc_html( $plus['text'] ); ?></span></li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <?php if ( $menuses ) : ?>
                                    <div class="review-header__menuses">
                                        <div class="review-header__menuses-title">Минусы</div>
                                        <ul class="pros-casino">
                                            <?php foreach ( $menuses as $menus ) : ?>
                                                <?php if ( $menus['text'] ) : ?>
                                                    <li><img src="<?php bloginfo( 'template_directory' ); ?>/images/menus.svg" alt=""><span><?php echo esc_html( $menus['text'] ); ?></span></li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!--<div class="rating-view">
                                    <div class="rating-view__stars">
                                        <?php /*echo rmp_get_visual_rating( $post_id ); */?>
                                    </div>
                                    <div class="rating-view__number">
                                        <span><?php /*echo rmp_get_avg_rating( $post_id ); */?></span>/5
                                    </div>
                                </div>-->
                        </div>
                    </div>
                    <div class="review-header__center">
                        <?php if ( $pros ) : ?>
                            <div class="review-header__pros">
                                <div class="review-header__pros-title">Плюсы</div>
                                <ul class="pros-casino">
                                    <?php foreach ( $pros as $plus ) : ?>
                                        <?php if ( $plus['text'] ) : ?>
                                            <li><img src="<?php bloginfo( 'template_directory' ); ?>/images/plus.svg" alt=""><span><?php echo esc_html( $plus['text'] ); ?></span></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php if ( $menuses ) : ?>
                            <div class="review-header__menuses">
                                <div class="review-header__menuses-title">Минусы</div>
                                <ul class="pros-casino">
                                    <?php foreach ( $menuses as $menus ) : ?>
                                        <?php if ( $menus['text'] ) : ?>
                                            <li><img src="<?php bloginfo( 'template_directory' ); ?>/images/menus.svg" alt=""><span><?php echo esc_html( $menus['text'] ); ?></span></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="review-header__right">
                        <div class="review-header__right-top">
                            <div class="review-header__votes">
                                <a href="<?php echo $permalink_review; ?>" class="votes-count">
                                    <img src="<?php bloginfo( 'template_directory' ); ?>/images/votes.svg" alt="">
                                    <span><?php echo num_declension( (int) rmp_get_vote_count( $id_review ), [ 'голос', 'голоса', 'голосов' ] ); ?></span>
                                </a>
                            </div>
                            <div class="review-header__reviews">
                                <a href="#comments-block" class="scroll-btn">
                                    <img src="<?php bloginfo( 'template_directory' ); ?>/images/reviews.svg" alt="">
                                    <span><?php echo num_declension( (int) get_comments_number( $post_id ), [ 'отзыв', 'отзыва', 'отзывов' ] ); ?></span>
                                </a>
                            </div>
                        </div>
                        <?php if ( $link ) : ?>
                            <?php echo do_shortcode('[prgpattern slug="' . esc_url( $link ) . '" title="Перейти на сайт" extern="true" class="form-red-btn form-red-btn_review-header"]'); ?>
                            <div class="form-red-btn_mobile">
                                <?php echo do_shortcode('[prgpattern slug="' . esc_url( $link ) . '" title="Перейти" extern="true" class="form-red-btn form-red-btn_review-header"]'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="review-link">
                    <a href="<?php echo $permalink_review; ?>" class="btn btn_green_line">Перейти к Обзору</a>
                </div>

                <div class="page-content-main">
                    <div class="page-content-main__left">

                        <div class="review-nuances review-block">
                            <div class="review-block__title">Игровые нюансы</div>
                            <div class="review-block__items">
                                <?php if ( $lic ) : ?>
                                    <div class="review-block__item review-block__item_lic">
                                        <div class="review-block__item-title">
                                            <div class="review-block__item-img">
                                                <img src="<?php bloginfo( 'template_directory' ); ?>/images/lic.svg" alt="">
                                            </div>
                                            <span>Лицензия</span>
                                        </div>
                                        <div class="review-block__item-line"></div>
                                        <div class="review-block__item-value"><?php echo $lic; ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if ( $time ) : ?>
                                    <div class="review-block__item review-block__item_time">
                                        <div class="review-block__item-title">
                                            <div class="review-block__item-img">
                                                <img src="<?php bloginfo( 'template_directory' ); ?>/images/time.svg" alt="">
                                            </div>
                                            <span>Время вывода</span>
                                        </div>
                                        <div class="review-block__item-line"></div>
                                        <div class="review-block__item-value"><?php echo $time; ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if ( $limit ) : ?>
                                    <div class="review-block__item review-block__item_limit">
                                        <div class="review-block__item-title">
                                            <div class="review-block__item-img">
                                                <img src="<?php bloginfo( 'template_directory' ); ?>/images/limit.svg" alt="">
                                            </div>
                                            <span>Лимит вывода</span>
                                        </div>
                                        <div class="review-block__item-line"></div>
                                        <div class="review-block__item-value"><?php echo $limit; ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if ( $dep ) : ?>
                                    <div class="review-block__item review-block__item_dep">
                                        <div class="review-block__item-title">
                                            <div class="review-block__item-img">
                                                <img src="<?php bloginfo( 'template_directory' ); ?>/images/dep.svg" alt="">
                                            </div>
                                            <span>Способы депозита</span>
                                        </div>
                                        <div class="review-block__item-line"></div>
                                        <div class="review-block__item-value"><?php echo $dep; ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if ( $ver ) : ?>
                                    <div class="review-block__item review-block__item_ver">
                                        <div class="review-block__item-title">
                                            <div class="review-block__item-img">
                                                <img src="<?php bloginfo( 'template_directory' ); ?>/images/ver.svg" alt="">
                                            </div>
                                            <span>Верификация</span>
                                        </div>
                                        <div class="review-block__item-line"></div>
                                        <div class="review-block__item-value"><?php echo $ver; ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="review-blocks">
                            <?php if ( $djeck ) : ?>
                                <div class="review-blocks__item review-blocks__item_djeck">
                                    <div class="review-blocks__item-title">Джекпот</div>
                                    <div class="review-blocks__item-value"><?php echo esc_html( $djeck ); ?> RUB</div>
                                </div>
                            <?php endif; ?>
                            <?php if ( $return_to_player ) : ?>
                                <div class="review-blocks__item review-blocks__item_return">
                                    <div class="review-blocks__item-title">Return to player</div>
                                    <div class="review-blocks__item-value"><?php echo esc_html( $return_to_player ); ?>%</div>
                                </div>
                            <?php endif; ?>
                            <?php if ( $speed ) : ?>
                                <div class="review-blocks__item review-blocks__item_speed">
                                    <div class="review-blocks__item-title">Скорость вывода</div>
                                    <div class="review-blocks__item-value"><?php echo esc_html( $speed ); ?> из 10</div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="review-about review-block">
                            <div class="review-block__title">О компании</div>
                            <div class="review-block__items">
                                <?php if ( $tip_casino ) : ?>
                                    <div class="review-block__item">
                                        <div class="review-block__item-title">
                                            <div class="review-block__item-img">
                                                <img src="<?php bloginfo( 'template_directory' ); ?>/images/tip_casino.svg" alt="">
                                            </div>
                                            <span>Тип казино</span>
                                        </div>
                                        <div class="review-block__item-line"></div>
                                        <div class="review-block__item-value"><?php echo $tip_casino; ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if ( $date ) : ?>
                                    <div class="review-block__item">
                                        <div class="review-block__item-title">
                                            <div class="review-block__item-img">
                                                <img src="<?php bloginfo( 'template_directory' ); ?>/images/date.svg" alt="">
                                            </div>
                                            <span>Дата Основания</span>
                                        </div>
                                        <div class="review-block__item-line"></div>
                                        <div class="review-block__item-value"><?php echo $date; ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if ( $site ) : ?>
                                    <div class="review-block__item">
                                        <div class="review-block__item-title">
                                            <div class="review-block__item-img">
                                                <img src="<?php bloginfo( 'template_directory' ); ?>/images/site.svg" alt="">
                                            </div>
                                            <span>Сайт</span>
                                        </div>
                                        <div class="review-block__item-line"></div>
                                        <div class="review-block__item-value">
                                            <?php echo do_shortcode('[prgpattern slug="' . esc_url( $site ) . '" title="' . esc_url( $site ) . '" extern="true" class="form-red-btn_link"]'); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ( $phone ) : ?>
                                    <div class="review-block__item">
                                        <div class="review-block__item-title">
                                            <div class="review-block__item-img">
                                                <img src="<?php bloginfo( 'template_directory' ); ?>/images/phone.svg" alt="">
                                            </div>
                                            <span>Телефон</span>
                                        </div>
                                        <div class="review-block__item-line"></div>
                                        <div class="review-block__item-value"><a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></div>
                                    </div>
                                <?php endif; ?>
                                <?php if ( $mail ) : ?>
                                    <div class="review-block__item">
                                        <div class="review-block__item-title">
                                            <div class="review-block__item-img">
                                                <img src="<?php bloginfo( 'template_directory' ); ?>/images/mail.svg" alt="">
                                            </div>
                                            <span>Почта</span>
                                        </div>
                                        <div class="review-block__item-line"></div>
                                        <div class="review-block__item-value"><a href="mailto:<?php echo $mail; ?>"><?php echo $mail; ?></a></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if ( $bonuses ) : ?>
                            <div class="review-bonuses">
                                <?php foreach ( $bonuses as $bonus_item ) :
                                    $bonus               = $bonus_item['bonus'] ? $bonus_item['bonus'] : '';
                                    $title               = $bonus_item['title'] ? $bonus_item['title'] : '';
                                    $min_depozit         = $bonus_item['min_depozit'] ? $bonus_item['min_depozit'] : '';
                                    $vejdzher            = $bonus_item['vejdzher'] ? $bonus_item['vejdzher'] : '';
                                    $makssumma_bonusa    = $bonus_item['makssumma_bonusa'] ? $bonus_item['makssumma_bonusa'] : '';
                                    $dopolnitelnyj_bonus = $bonus_item['dopolnitelnyj_bonus'] ? $bonus_item['dopolnitelnyj_bonus'] : ''; ?>

                                    <div class="review-bonuses__item">
                                        <?php if ( $bonus ) : ?>
                                            <div class="review-bonuses__item-bonus"><span><?php echo esc_html( $bonus ); ?>%</span></div>
                                        <?php endif; ?>
                                        <?php if ( $title ) : ?>
                                            <div class="review-bonuses__item-title-wrap">
                                                <div class="review-bonuses__item-title"><?php echo esc_html( $title ); ?></div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="review-bonuses__item-block">
                                            <?php if ( $min_depozit ) : ?>
                                                <div class="review-bonuses__item-block-item">
                                                    <div class="review-bonuses__item-block-item-title">Мин. депозит</div>
                                                    <div class="review-bonuses__item-block-item-value"><?php echo esc_html( $min_depozit ); ?> RUB</div>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ( $vejdzher ) : ?>
                                                <div class="review-bonuses__item-block-item">
                                                    <div class="review-bonuses__item-block-item-title">Вейджер</div>
                                                    <div class="review-bonuses__item-block-item-value">x<?php echo esc_html( $vejdzher ); ?></div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="review-bonuses__item-block-item">
                                                <div class="review-bonuses__item-block-item-title">Макс. сумма бонуса</div>
                                                <?php $makssumma_bonusa = ! $makssumma_bonusa ? 'Нет ограничений' : $makssumma_bonusa; ?>
                                                <div class="review-bonuses__item-block-item-value"><span><?php echo esc_html( $makssumma_bonusa ); echo $makssumma_bonusa !== 'Нет ограничений' ? ' RUB' : ''; ?></span></div>
                                            </div>
                                            <div class="review-bonuses__item-block-item">
                                                <div class="review-bonuses__item-block-item-title">Доп. бонус</div>
                                                <?php $dopolnitelnyj_bonus = ! $dopolnitelnyj_bonus ? 'Отсутствует' : $dopolnitelnyj_bonus; ?>
                                                <div class="review-bonuses__item-block-item-value"><?php echo esc_html( $dopolnitelnyj_bonus ); ?></div>
                                            </div>
                                        </div>
                                        <div class="review-bonuses__item-bottom">
                                            <?php if ( $link ) : ?>
                                                <?php echo do_shortcode('[prgpattern slug="' . esc_url( $link ) . '" title="Активировать бонус" extern="true" class="form-red-btn form-red-btn_review-bonuses"]'); ?>
                                            <?php endif; ?>
                                            <div class="review-bonuses__item-dop">
                                                <img src="<?php bloginfo( 'template_directory' ); ?>/images/dop.svg" alt="">
                                                <div class="review-bonuses__item-dop-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat laoreet et urna at lectus hac sit faucibus donec. Urna at eget in ultricies. Sit lorem vitae mauris quisque sed nibh sed suscipit. Pulvinar urna accumsan neque, tortor viverra sagittis.</div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="page-content-main__content" id="comments-block">
                            <?php $comments_count = get_comments_number(); ?>
                            <div class="comments__header">
                                <h1 class="page-title"><?php the_title(); ?></h1>
                                <div class="comments__counter"><span><?php echo num_declension( $comments_count, [ 'отзыв', 'отзыва', 'отзывов' ] ); ?></span></div>
                            </div>
                            <div class="content-style">
                                <?php the_content(); ?>
                            </div>

                            <?php if ( comments_open() || get_comments_number() ) {
                                comments_template();
                            } ?>
                        </div>

                    </div>
                    <?php require get_template_directory() . '/sidebar.php'; ?>
                </div>

            </div>
        </div>
    <?php endwhile; endif; ?>

<?php get_footer(); ?>
