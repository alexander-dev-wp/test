<?php
/**
 * Template Name: Contact Page
 */

get_header(); ?>

    <main>
        <?php $background = get_field('contact_hero_background') ?>
        <section class="contact__hero" <?php echo bg($background) ?>>
            <div class="grid-container">
                <div class="contact__hero-wrapper">
                    <?php if ($title = get_field('contact_hero_title')): ?>
                        <h1><?php echo $title ?></h1>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <section class="contact">

            <div class="grid-container">
                <div class="contact__wrapper">
                    <div class="cell medium-6">
                        <div class="contact__links">
                            <?php if ($phone = get_field('phone', 'options')): ?>
                                <p class="contact-link contact-link--phone"><span>Phone: </span><a
                                            href="tel:<?php echo sanitize_number($phone); ?>"><?php echo $phone; ?></a>
                                </p>
                            <?php endif; ?>
                            <?php if ($email = get_field('email', 'options')): ?>
                                <p class="contact-link contact-link--email"><span>Email: </span><a
                                            href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                                </p>
                            <?php endif; ?>

                            <?php if ($email = get_field('business_hours', 'options')): ?>
                                <p class="contact-link contact-link--hours"><span>Business Hours: </span><span class="business-hours"><?php echo $email; ?></span>
                                </p>
                            <?php endif; ?>

                            <?php if ($address = get_field('address', 'option')): ?>
                                <address class="contact-link contact-link--address">
                                    <span>Store Address: </span><a target="_blank"
                                            href="<?php echo get_address_url($address); ?>"><?php echo $address; ?></a>
                                </address>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (class_exists('GFAPI') && ($contact_form = get_field('contact_form')) && is_array($contact_form)): ?>
                        <div class="contact__form-wrapper">
                            <?php if ($title = get_field('form_title')): ?>
                                <h5><?php echo $title ?></h5>
                            <?php endif; ?>
                            <div class="contact__form">
                                <?php echo do_shortcode("[gravityform id='{$contact_form['id']}' title='false' description='false' ajax='true']"); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <section class="contact__map-section" id="location">
            <div class="grid-container">
                <div class="contact__map-wrapper">
                    <?php if ($content = get_field('map_content')): ?>
                        <div class="contact__map-content text-large">
                            <?php echo $content ?>
                        </div>
                    <?php endif; ?>
                    <?php
                    $map_type = get_field('map_type', 'options');
                    $map_field_key = $map_type == 'google' ? 'location' : ($map_type == 'iframe' ? 'map_iframe' : 'map_image');
                    $location = get_field($map_field_key, 'options');

                    if ($location): ?>
                        <div class="contact__map-wrap">
                            <?php if ($map_type == 'google'): ?>
                                <div class="acf-map contact__map">
                                    <div class="marker" data-lat="<?php echo $location['lat']; ?>"
                                         data-lng="<?php echo $location['lng']; ?>"
                                         data-marker-icon="<?php echo IMAGE_ASSETS . 'map-marker.png'; ?>"><?php echo '<p>' . $location['address'] . '</p>'; ?></div>
                                </div>
                            <?php elseif ($map_type == 'iframe'): ?>
                                <div class="contact__map">
                                    <?php echo $location; ?>
                                </div>
                            <?php else: ?>
                                <div class="contact__map">
                                    <?php echo wp_get_attachment_image($location, '1536x1536', false, array(
                                        'class' => 'contact__map-img',
                                        'alt' => get_field('address', 'options') ?: '',
                                    )); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

<?php get_footer(); ?>