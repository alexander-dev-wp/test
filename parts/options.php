<?php
global $post

?>
<section class="value__section <?php echo $post->post_name . '__value-section' ?>">
    <div class="grid-container">
        <div class="value__wrapper">
            <?php if ($title = get_field('option_title')): ?>
                <h2><?php echo $title ?></h2>
            <?php endif; ?>
            <?php if (have_rows('options_repeater')): ?>
                <div class="value__cards">
                    <?php $counter = 0 ?>
                    <?php while (have_rows('options_repeater')):
                        the_row();
                        $counter++;
                        ?>
                        <div class="value__card-item">
                            <?php if ($image = get_sub_field('image')): ?>
                                <?php echo wp_get_attachment_image($image["id"], 'full_hd', false, array('class' => 'value__card-image')); ?>
                            <?php endif; ?>
                            <div class="value__card-content">
                                <div class="value__card-title"
                                     style="background: url('<?php echo IMAGE_ASSETS . 'svg-crop.svg' ?>')">
                                    <div class="value__card-number"><?php echo $counter < 10 ? '0' : '' ?><?php echo $counter ?></div>
                                    <?php if ($title = get_sub_field('title')): ?>
                                        <h5><?php echo $title ?></h5>
                                    <?php endif; ?>
                                </div>
                                <?php if ($text = get_sub_field('text')): ?>
                                    <div class="value__card-text">
                                        <div><p><?php echo $text ?></p></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>