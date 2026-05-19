<?php
?>
<?php if (have_rows('slider')): ?>
    <section class="slider__section hide-for-small-only">
        <div class="slider__wrapper">
            <?php while (have_rows('slider')):the_row() ?>
                <div>
                    <div class="slider__item">
                        <?php if ($image = get_sub_field('slide')): ?>
                            <?php echo wp_get_attachment_image($image["id"], 'full_hd') ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
<?php endif; ?>
<?php if (have_rows('slider_mob')): ?>
    <section class="slider__section hide-for-medium">
        <div class="slider__wrapper">
            <?php while (have_rows('slider_mob')):the_row() ?>
                <div>
                    <div class="slider__item">
                        <?php if ($image = get_sub_field('slide')): ?>
                            <?php echo wp_get_attachment_image($image["id"], 'full_hd') ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
<?php endif; ?>
