<?php
?>
<!--<section class="accordion__section">-->
<!--    <div class="grid-container">-->
<!--        --><?php //if ($title = get_field('accordion_title')): ?>
<!--            <h3>--><?php //echo $title ?><!--</h3>-->
<!--        --><?php //endif; ?>
<!--        <div class="accordion__wrapper">-->
<!--            <div class="accordion__content">-->
<!--                --><?php //if ($image = get_field('accordion_image')): ?>
<!--                    --><?php //echo wp_get_attachment_image($image["id"], 'full_hd') ?>
<!--                --><?php //endif; ?>
<!--            </div>-->
<!--            --><?php //if (have_rows('accordion')): ?>
<!--                <div class="accordion accordion__block" data-accordion data-allow-all-closed="true">-->
<!--                    --><?php //while (have_rows('accordion')): the_row(); ?>
<!--                        --><?php //$title = get_sub_field('title');
//                        $content = get_sub_field('text');
//                        $image = get_sub_field('image'); ?>
<!--                        <div class="accordion-item --><?php //echo get_row_index() == 1 ? 'is-active' : ''; ?><!--"-->
<!--                             data-accordion-item>-->
<!--                            <a href="#" class="accordion-title"><h5>--><?php //echo $title; ?><!--</h5></a>-->
<!--                            <div class="accordion-content" data-tab-content>-->
<!--                                <p>--><?php //echo $content; ?><!--</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    --><?php //endwhile; ?>
<!--                </div>-->
<!--            --><?php //endif; ?>
<!--        </div>-->
<!--    </div>-->
<!--</section>-->

<section class="accordion__section">
    <div class="grid-container">
        <?php if ($title = get_field('accordion_title')): ?>
            <h3><?php echo esc_html($title); ?></h3>
        <?php endif; ?>

        <?php if (have_rows('accordion')): ?>
            <div class="accordion__wrapper accordion-images">

                <div class="accordion__content">
                    <?php $index = 1; ?>
                    <?php while (have_rows('accordion')): the_row(); ?>
                        <?php $image = get_sub_field('image'); ?>
                        <?php if ($image): ?>
                            <div class="accordion-image <?php echo $index === 1 ? 'is-active' : ''; ?>"
                                 data-index="<?php echo $index; ?>">
                                <?php echo wp_get_attachment_image($image["id"], 'full_hd'); ?>
                            </div>
                        <?php endif; ?>
                        <?php $index++; ?>
                    <?php endwhile; ?>
                </div>


                <div class="accordion accordion__block" data-accordion data-allow-all-closed="true">
                    <?php $index = 1; ?>
                    <?php while (have_rows('accordion')): the_row(); ?>
                        <?php
                        $title = get_sub_field('title');
                        $content = get_sub_field('text');
                        ?>
                        <div class="accordion-item <?php echo $index === 1 ? 'is-active' : ''; ?>"
                             data-accordion-item data-index="<?php echo $index; ?>">
                            <a href="#" class="accordion-title"><h5><?php echo esc_html($title); ?></h5></a>
                            <div class="accordion-content" data-tab-content>
                                <p><?php echo $content; ?></p>
                            </div>
                        </div>
                        <?php $index++; ?>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
