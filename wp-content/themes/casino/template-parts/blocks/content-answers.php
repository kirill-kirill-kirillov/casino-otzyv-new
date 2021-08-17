<?php
$answers = get_field( 'answers' ) ? get_field( 'answers' ) : ''; ?>

<?php if ( $answers ) : ?>
    <div class="block-answers">
        <img src="<?php bloginfo( 'template_directory' ); ?>/images/questions.svg" alt="">
        
        <div class="block-answers__title">Ответы на вопросы</div>

        <div class="block-answers__items">
            <?php foreach ( $answers as $key => $answer ) : ?>
                <?php if ( $answer['question'] ) : ?>
                    <div class="block-answers__item<?php echo $key === 0 ? ' active' : ''; ?>">
                        <div class="block-answers__item-button">
                            <span></span>
                            <span></span>
                        </div>
                        <div class="block-answers__item-question"><?php echo esc_html( $answer['question'] ); ?></div>
                        <?php if ( $answer['answer'] ) : ?>
                            <div class="block-answers__item-answer"<?php echo $key === 0 ? ' style="display: block;"' : ''; ?>><?php echo esc_html( $answer['answer'] ); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
