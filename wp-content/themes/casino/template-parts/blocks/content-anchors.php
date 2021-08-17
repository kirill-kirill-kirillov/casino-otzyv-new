<?php
$anchors = get_field( 'anchors' ) ? get_field( 'anchors' ) : ''; ?>

<?php if ( $anchors ) : ?>
    <div class="block-anchors">
        <div class="block-anchors__title">
            <span>Содержание</span>
            <img src="<?php bloginfo( 'template_directory' ); ?>/images/ar-btm.svg" alt="">
        </div>
        <div class="block-anchors__block">
            <div class="block-anchors__items">
                <div class="content-style">
                    <ol>
                        <?php $i = 1; ?>
                        <?php foreach ( $anchors as $anchor ) : ?>
                            <?php if ( $anchor['text'] ) : ?>
                                <li class="block-anchors__item">
                                    <a href="#<?php echo $anchor['anchor'] ? $anchor['anchor'] : ''; ?>" class="scroll-btn"><?php echo $anchor['text']; ?></a>
                                </li>
                                <?php $i++; endif; ?>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>