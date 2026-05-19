<?php
global $post
?>
<section class="process__section <?php echo $post->post_name . '-process__section'?>">
    <div class="grid-container">
        <?php if ($subtitle = get_field('process_subtitle')): ?>
            <div class="process__subtitle subtitle"><?php echo $subtitle ?></div>
        <?php endif; ?>
        <?php if ($text = get_field('process_text')): ?>
            <div class="process__text text-large"><?php echo $text ?></div>
        <?php endif; ?>
        <?php if (have_rows('process_repeater')): ?>
            <div class="process-repeater__wrapper">
                <?php while (have_rows('process_repeater')):the_row() ?>
                    <?php $icon = get_sub_field('icon'); ?>
                    <?php $text = get_sub_field('text'); ?>
                    <?php $link = get_sub_field('link') ?>
                    <div class="process__item">
                            <div class="process-item__icon">
                                <?php if ($icon) {
                                    echo wp_get_attachment_image($icon["id"], 'full_hd');
                                } ?>
                                <div class="process-item__arrow"></div>
                            </div>
                            <?php if ($text): ?>
                                <div class="process-item__text">
                                    <?php echo $text ?>
                                </div>
                            <?php endif; ?>
                    </div>

                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
