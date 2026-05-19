<?php
?>
<?php $background = get_field('showroom_background') ?>
<?php $gradient = get_field('gradient');
$centered = get_field('centered');
$size = get_field('modile_size');
global $post
?>
<section class="showroom__section
 <?php echo $gradient ? 'showroom__gradient' : '' ?>
 <?php echo $centered ? 'showroom__centered' : '' ?>
 <?php echo $size === "small" ? 'showroom__small' : '' ?>
 <?php echo $post->post_name . '__showroom-section' ?>">
    <div class="grid-container">
        <div class="showroom__wrapper"
             style="background: url('<?php echo $background["url"] ?>') no-repeat; background-size: cover">
            <div class="showroom__content">
                <?php if ($text = get_field('showroom_content')): ?>
                    <div class="text-medium"><?php echo $text ?></div>
                <?php endif ?>
                <?php if ($link = get_field('showroom_link')): ?>
                    <a href="<?php echo $link["url"] ?>" class="showroom__link button__link">
                        <?php if ($icon = get_field('showroom_link_icon')): ?>
                            <?php echo wp_get_attachment_image($icon["id"], 'full_hd'); ?>
                        <?php endif; ?>
                        <span><?php echo $link["title"] ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if ($logo = get_field('showroom_logo')): ?>
        <?php echo wp_get_attachment_image($logo["id"], 'full_hd', false, array('class' => 'showroom__logo')) ?>
    <?php endif; ?>
</section>