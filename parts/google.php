<?php $query_arg = array(
    'post_type' => 'google-reviews',
    'order' => 'ASC',
    'orderby' => 'date',
    'posts_per_page' => 100,
    'post_status' => 'publish'
);
$the_query = new WP_Query($query_arg);
if ($the_query->have_posts()) : ?>
    <section class="google__section">
        <div class="grid-container">
            <div class="google__wrapper">
                <?php if ($text = get_field('google_text')): ?>
                    <div class="text-large">
                        <?php echo $text ?>
                    </div>
                <?php endif; ?>
                <div class="google__slider">
                    <?php while ($the_query->have_posts()) :
                        $the_query->the_post(); ?>
                        <div>
                            <div class="google__item">
                                <div class="google__logo"><?php the_post_thumbnail('medium_large', array('class' => '')); ?></div>
                                <div class="google__content text-medium"><?php the_content(); ?></div>
                                <div class="google__title"><?php the_title(); ?></div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif;
wp_reset_query(); ?>

