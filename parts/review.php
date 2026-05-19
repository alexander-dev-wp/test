<?php $align = get_field('align') ?>
<section class="review__section <?php echo $align == 'bottom' ? 'review__bottom' : '' ?>">
    <div class="grid-container">
        <div class="review__wrapper">
            <?php $text = get_field('review_text') ?>
            <?php if ($text || have_rows('review_logos')): ?>
                <div class="review__content">
                    <?php if ($text): ?>
                        <?php echo $text ?>
                    <?php endif; ?>
                    <?php if (have_rows('review_logos')): ?>
                        <div class="review__links">
                            <?php while (have_rows('review_logos')):the_row() ?>
                                <?php $image = get_sub_field('logo'); ?>
                                <?php $link = get_sub_field('link'); ?>
                                <div class="review__link-item">
                                    <a href="<?php echo $link ? $link["url"] : '' ?>" target=”_blank”>
                                        <?php if ($image): ?>
                                            <?php echo wp_get_attachment_image($image["id"], 'full_hd') ?>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (have_rows('review_stat')): ?>
                <div class="review__stats">
                    <?php while (have_rows('review_stat')):the_row() ?>
                        <?php $text = get_sub_field('text');
                        $number = get_sub_field('number');
                        ?>
                        <div class="stat__item">
                            <div class="stat__item-number"><?php echo $number ?></div>
                            <div class="stat__item-text text-medium"><p><?php echo $text ?></p></div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>