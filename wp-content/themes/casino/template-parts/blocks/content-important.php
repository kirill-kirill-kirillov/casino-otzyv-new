<?php
$title = get_field( 'title' ) ? get_field( 'title' ) : '';
$text  = get_field( 'text' ) ? get_field( 'text' ) : ''; ?>

<?php if ( $title || $text ) : ?>
    <div class="block-important">
        <img src="<?php bloginfo( 'template_directory' ); ?>/images/important.svg" alt="">

        <?php if ( $title ) : ?>
            <div class="block-important__title"><?php echo esc_html( $title ); ?></div>
        <?php endif; ?>

        <?php if ( $text ) : ?>
            <div class="block-important__text"><?php echo esc_html( $text ); ?></div>
        <?php endif; ?>
    </div>
<?php endif; ?>


<div class="block-important">
    <img src="/wp-content/themes/casino/images/important.svg" alt="">
    <div class="block-important__title">Заголовок</div>
    <div class="block-important__text">Текст</div>
</div>