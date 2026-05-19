<div class="share-box">

    <svg xmlns="http://www.w3.org/2000/svg" width="230" height="100"
         viewBox="0 0 230 100" fill="none"
         style="&#10;    background-color: transparent;&#10;">
        <g style="mix-blend-mode:exclusion;fill: red;" opacity="0.2">
            <path d="M27.2185 171.642C11.6945 148.795 2.43532 121.867 0.459374 93.8199C-1.51657 65.7727 3.86731 37.693 16.0188 12.6698C28.1703 -12.3535 46.6185 -33.3508 69.3341 -48.0125C92.0497 -62.6741 118.153 -70.4319 144.771 -70.4326H145.728C169.202 -70.4691 192.33 -64.4452 213.098 -52.8851C224.78 -29.5841 230.561 -3.48787 229.881 22.8704C229.201 49.2286 222.083 74.9534 209.218 97.5474C196.352 120.141 178.176 138.837 156.455 151.82C134.733 164.802 110.204 171.631 85.2478 171.642H27.2185Z"
                  fill="#0A1C8F" style="&#10;    fill: white;&#10;"/>
        </g>
    </svg>

    <h6 class="share-box__title"><?php _e('Share with your community!'); ?></h6>
    <ul class="share-box__links share-links">
        <?php
        $share_links = [
            'facebook' => 'fa-brands fa-square-facebook',
            'twitter' => 'fa-brands fa-square-x-twitter',
            'linkedin' => 'fa-brands fa-linkedin',
        ];

        foreach ($share_links as $network => $icon):
            // Skip pinterest if post does not have thumbnail
            if ($network == 'pinterest' && !has_post_thumbnail(get_the_ID())) {
                continue;
            }
            ?>
            <li class="share-links__item">
                <a href="<?php echo get_share_link_url(get_the_ID(), $network); ?>"
                   class="share-links__link <?php echo $network !== 'email' ? 'js-share-link' : ''; ?>" target="_blank">
                    <span class="<?php echo $icon; ?>"></span></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>