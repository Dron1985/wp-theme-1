<?php
$footer = get_field('fields_footer', 'options');
$subscribe = get_field('subscribe_popup', 'options');
$cookie_popup = get_field('cookie_popup', 'options');

if (!is_404() && !is_post_type_archive('locations') && !is_page_template('templates/contact-us.php') && !is_search()) {
    get_template_part('template-parts/global/contact-block');
}

if (!is_404() && !empty($footer['recognized_in']['logos'])) : ?>
    <div class="recognized-in">
        <div class="container">
            <?php if (isset($footer['recognized_in']['title']) && !empty($footer['recognized_in']['title'])) : ?>
                <div class="h6"><?php echo $footer['recognized_in']['title']; ?></div>
            <?php endif; ?>
            <div class="logos-list">
                <?php foreach ($footer['recognized_in']['logos'] as $logo) : ?>
                    <div class="item"><img src="<?php echo $logo['logo']['sizes']['medium']; ?>" alt="<?php echo $logo['logo']['alt']; ?>"></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!--recognized-in-->
<?php endif; ?>

<footer class="footer @@alter-class">
    <div class="container">
        <div class="logo-holder">
            <?php if (isset($footer['logo']['sizes'])) : ?>
                <div class="logo">
                    <a href="<?php echo home_url('/'); ?>">
                        <img src="<?php echo $footer['logo']['sizes']['medium']; ?>" alt="<?php echo $footer['logo']['alt']; ?>">
                    </a>
                </div>
            <?php endif; ?>
            <button class="back-to-top"><?php echo __('Back to Top', 'barley-theme'); ?></button>
        </div>
    </div>
    <div class="container">
        <nav class="footer-nav-holder">
            <?php wp_nav_menu(array('menu' => 'footer-menu', 'menu_class' => 'footer-nav', 'container' => '', 'menu_id' => 'footer-menu', 'fallback_cb' => '__return_empty_string')); ?>

            <?php if (isset($footer['link_facebook']) || isset($footer['link_twitter']) || isset($footer['link_linkedin'])) : ?>
                <div class="social">
                    <div class="title"><?php echo __('Follow Us', 'barley-theme'); ?></div>
                    <ul class="social-list">
                        <?php if (isset($footer['link_facebook']) && !empty($footer['link_facebook'])) : ?>
                            <li>
                                <a href="<?php echo $footer['link_facebook']; ?>" target="_blank" rel="nofollow">
                                    <?php get_template_part('template-parts/svg/facebook'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($footer['link_twitter']) && !empty($footer['link_twitter'])) : ?>
                            <li>
                                <a href="<?php echo $footer['link_twitter']; ?>" target="_blank" rel="nofollow">
                                    <?php get_template_part('template-parts/svg/twitter'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($footer['link_linkedin']) && !empty($footer['link_linkedin'])) : ?>
                            <li>
                                <a href="<?php echo $footer['link_linkedin']; ?>" target="_blank" rel="nofollow">
                                    <?php get_template_part('template-parts/svg/linkedin'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </nav>
    </div>
    <div class="container">
        <div class="copy-holder">
            <?php if (!empty($footer['copyright'])) :
                $text_before = (isset($footer['copyright']['text_before']) && !empty($footer['copyright']['text_before'])) ? $footer['copyright']['text_before'] : '';
                $text_after = (isset($footer['copyright']['text_after']) && !empty($footer['copyright']['text_after'])) ? $footer['copyright']['text_after'] : ''; ?>
                <p><?php echo $text_before.' &copy; '.date('Y').' '.$text_after; ?></p>
            <?php endif; ?>
            <?php wp_nav_menu(array('menu' => 'terms-menu', 'menu_class' => 'add-links', 'container' => '', 'menu_id' => 'terms-menu', 'fallback_cb' => '__return_empty_string')); ?>
        </div>
    </div>
</footer>

<div class="popup">
    <div class="popup-holder">
        <div id="subscribe-popup" class="popup-info subscribe-popup">
            <button class="close">
                <svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <title>Close icon</title>
                    <path d="M7.67749 21.2285L21.8196 7.08632" stroke="#8D1414" stroke-width="3" stroke-linecap="round"/>
                    <path d="M7.67749 7.08612L21.8196 21.2283" stroke="#8D1414" stroke-width="3" stroke-linecap="round"/>
                </svg>
            </button>
            <?php if (isset($subscribe['title']) && !empty($subscribe['title'])) : ?>
                <h3><?php echo $subscribe['title']; ?></h3>
            <?php endif; ?>
            <?php if (isset($subscribe['subscribe_form']) && !empty($subscribe['subscribe_form'])) : ?>
                <div class="form-holder">
                    <?php echo do_shortcode($subscribe['subscribe_form']); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($cookie_popup) && $cookie_popup['show_cookie'] == true ) : ?>
            <div id="bio-popup" class="popup-info bio-popup">
                <button class="close">
                    <?php get_template_part('template-parts/svg/icon-close'); ?>
                </button>
                <?php if (isset($cookie_popup['title']) && !empty($cookie_popup['title'])) : ?>
                    <div class="title h4"><?php echo $cookie_popup['title']; ?></div>
                <?php endif; ?>
                <?php if (isset($cookie_popup['description']) && !empty($cookie_popup['description'])) : ?>
                    <div class="note">
                        <?php echo $cookie_popup['description']; ?>
                    </div>
                <?php endif; ?>
                <div class="buttons-holder">
                    <a href="#" class="button">
                        <?php echo __('Ok', 'barley-theme'); ?>
                        <?php get_template_part('template-parts/svg/icon-cancel'); ?>
                    </a>
                    <button class="clear"><span><?php echo __('Cancel', 'barley-theme'); ?></span></button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($cookie_popup) && $cookie_popup['show_cookie'] == true) : ?>
    <div class="cookies-popup">
        <div class="popup-holder">
            <div class="cookie-info popup-info">
                <button class="close">
                    <?php get_template_part('template-parts/svg/icon-close'); ?>
                </button>
                <?php if (isset($cookie_popup['title']) && !empty($cookie_popup['title'])) : ?>
                    <div class="title h4"><?php echo $cookie_popup['title']; ?></div>
                <?php endif; ?>
                <?php if (isset($cookie_popup['description']) && !empty($cookie_popup['description'])) : ?>
                    <div class="note">
                        <?php echo $cookie_popup['description']; ?>
                    </div>
                <?php endif; ?>
                <div class="buttons-holder">
                    <button class="button accept-cookie">
                        <?php echo __('Ok', 'barley-theme'); ?>
                        <?php get_template_part('template-parts/svg/icon-cancel'); ?>
                    </button>
                    <button class="clear"><span><?php echo __('Cancel', 'barley-theme'); ?></span></button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!--popup-->