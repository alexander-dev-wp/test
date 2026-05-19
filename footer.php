<?php
/**
 * Footer
 */
?>
 

<!-- BEGIN of footer -->
<footer class="footer">
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="cell large-4 medium-12 footer__logo-wrapper">
                <div class="footer__logo">
                    <?php if ($footer_logo = get_field('footer_logo', 'options')):
                        $logo_image = wp_get_attachment_image($footer_logo['id'], 'medium', false, [
                            'class' => 'custom-logo',
                            'itemprop' => 'siteLogo',
                            'alt' => get_bloginfo('name'),
                        ]);
                        echo sprintf('<a href="%1$s" class="custom-logo-link" rel="home" title="%2$s" itemscope>%3$s</a>', esc_url(home_url('/')), get_bloginfo('name'), $logo_image);
                    else:
                        show_custom_logo();
                    endif; ?>
                </div>
                <?php if ($text = get_field('footer_logo_text', 'options')): ?>
                    <div class="footer__logo-text">
                        <?php echo $text ?>
                    </div>
                <?php endif; ?>
                <?php get_template_part('parts/socials'); // Social profiles ?>
            </div>
            <div class="cell large-8 medium-12 footer__link-wrapper">
                <div class="grid-x grid-padding-x">
                    <div class="cell large-3 medium-6 small-6 footer__menu">
                        <?php dynamic_sidebar('Footer Links') ?>
                    </div>
                    <div class="cell large-4 medium-6 small-6">
                        <?php dynamic_sidebar('Footer Products') ?>
                    </div>
                    <div class="cell large-4 medium-12 contact__info-wrapper footer__menu">
                        <h6>Contact info</h6>
                        <div class="contact__info">
                            <?php if ($address = get_field('address', 'option')):
                                ($address_link = get_field('address_link', 'option')) ?>
                                <address class="contact-link contact-link--address "><a target=”_blank”
                                                                                        href="<?php echo $address_link ? $address_link : get_address_url($address); ?>"><?php echo $address; ?></a>
                                </address>
                            <?php endif; ?>

                            <?php if ($phone = get_field('phone', 'options')): ?>
                                <p class="contact-link contact-link--phone"><a
                                            href="tel:<?php echo sanitize_number($phone); ?>"><?php echo $phone; ?></a>
                                </p>
                            <?php endif; ?>
                            <?php if ($email = get_field('email', 'options')): ?>
                                <p class="contact-link contact-link--email"><a
                                            href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                                </p>
                            <?php endif; ?>

                            <?php if ($email = get_field('business_hours', 'options')): ?>
                                <p class="contact-link contact-link--hours"><span><?php echo $email; ?></span>
                                </p>
                            <?php endif; ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($copyright = get_field('copyright', 'options')): ?>
        <div class="footer__copy">
            <div class="grid-container">
                <div class="footer__copy-wrapper">
                    <div class="copyright">
                        <?php echo $copyright; ?>
                    </div>
                    <?php dynamic_sidebar('Copyright Menu') ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</footer>
<!-- END of footer -->

<?php wp_footer(); ?>
<script src="/wp-content/themes/carpetwholesalers/assets/js/foundation.min.js" id="foundation.min-js"></script>
<script src="/wp-content/themes/carpetwholesalers/assets/js/plugins/slick.min.js" id="slick-js"></script>
<script src="/wp-content/themes/carpetwholesalers/assets/js/plugins/lazyload.min.js" id="lazyload-js"></script>
<script src="/wp-content/themes/carpetwholesalers/assets/js/plugins/select2.full.min.js" id="select2-js"></script>
<script src="/wp-content/themes/carpetwholesalers/assets/js/plugins/jquery.fancybox.v3.js" id="fancybox.v3-js"></script>
<script src="/wp-content/themes/carpetwholesalers/assets/js/plugins/malihu-custom-scrollbar-plugin-master/jquery.mCustomScrollbar.concat.min.js" id="custom-scrollbar-js"></script>
<script src="/wp-content/themes/carpetwholesalers/assets/js/global.js" id="global-js"></script>


</body>
</html>