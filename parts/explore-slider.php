<div class="hide-for-small-only explore__slider-wrapper">
    <?php if ($title = get_field('explore_slider_title')): ?>
        <h2><?php echo $title ?></h2>
    <?php endif; ?>
    <?php if (have_rows('explore_slider')): ?>
        <div class="explore__slider">
            <?php while (have_rows('explore_slider')):the_row() ?>
                <?php $slide = get_sub_field('image') ?>
                <div>
                    <div class="explore__slider-item">
                        <?php
                        $link = get_sub_field('link');
                        if (!empty($link)) : ?>
                            <a href="<?php echo esc_url($link); ?>">
                                <?php echo wp_get_attachment_image($slide["id"], 'full_hd'); ?>
                            </a>
                        <?php else : ?>
                            <?php echo wp_get_attachment_image($slide["id"], 'full_hd'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>
<div class="hide-for-medium explore__slider-wrapper">
    <?php if ($title = get_field('explore_slider_title')): ?>
        <h2><?php echo $title ?></h2>
    <?php endif; ?>
    <?php if (have_rows('explore_slider_mob')): ?>
        <div class="explore__slider">
            <?php while (have_rows('explore_slider_mob')):the_row() ?>
                <?php $slide = get_sub_field('image') ?>
                <div>
                    <div class="explore__slider-item">
                        <?php
                        $link = get_sub_field('link');
                        if (!empty($link)) : ?>
                            <a href="<?php echo esc_url($link); ?>">
                                <?php echo wp_get_attachment_image($slide["id"], 'full_hd'); ?>
                            </a>
                        <?php else : ?>
                            <?php echo wp_get_attachment_image($slide["id"], 'full_hd'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>