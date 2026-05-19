<?php
?>
<section class="faq__section">
    <div class="grid-container">
        <div class="faq__wrapper">
            <div class="faq__content">
                <?php if ($subtitle = get_field('faq_subtitle')): ?>
                    <div class="subtitle faq__subtitle"><?php echo $subtitle ?></div>
                <?php endif; ?>
                <?php if ($title = get_field('faq_title')): ?>
                    <h2><?php echo $title ?></h2>
                <?php endif; ?>
            </div>
            <?php if (have_rows('faq_wrapper')): ?>
                <div class="accordion faq__block" data-accordion data-allow-all-closed="true">
                    <?php while (have_rows('faq_wrapper')): the_row(); ?>
                        <?php $title = get_sub_field('question'); ?>
                        <?php $content = get_sub_field('answer'); ?>
                        <div class="accordion-item <?php echo get_row_index() == 1 ? 'is-active' : ''; ?>"
                             data-accordion-item>
                            <a href="#" class="accordion-title"><?php echo $title; ?></a>
                            <div class="accordion-content" data-tab-content>
                                <?php echo $content; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>