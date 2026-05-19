<?php
global $post
?>
<?php $video = get_field('content_video');
$image = get_field('content_image');
?>
<section
        class="content__section <?php echo $post->post_name . '-content__section' ?> <?php echo $video ? 'content__media-video' : 'content__media-image' ?>">
    <div class="grid-container">
        <div class="content__wrapper">

            <?php if ($video || $image): ?>
                <div class="content__media ">
                    <?php if ($image): ?>
                        <?php echo wp_get_attachment_image($image["id"], 'full_hd') ?>
                    <?php endif ?>
                    <?php if ($video): ?>
                        <video autoplay muted loop>
                            <source src="<?php echo esc_url($video["url"]) ?>" type="video/mp4">
                        </video>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php $subtitle = get_field('content_subtitle');
            $text = get_field('content_content');
            ?>
            <?php if ($subtitle || $text): ?>
                <div class="content__text-wrapper">
                    <?php if ($subtitle): ?>
                        <div class="content__subtitle subtitle"><?php echo $subtitle ?></div>
                    <?php endif; ?>
                    <?php if ($text): ?>
                        <div class="content__text">
                            <?php echo $text ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>