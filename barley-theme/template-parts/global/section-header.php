<?php $header = get_field('fields_header', 'option');
switch (true) {
    case is_404():
    case is_front_page():
    case is_home():
    case is_page_template('templates/about-us.php'):
    case is_page_template('templates/contact-us.php'):
    case is_page_template('templates/careers.php'):
    case is_page_template('templates/management-team.php'):
    case is_page_template('templates/your-life.php'):
    case is_page_template('templates/practice-excellence.php'):
    case is_post_type_archive('jobs'):
    case is_post_type_archive('locations'):
    case is_post_type_archive('resources'):
    case is_post_type_archive('events'):
    case is_post_type_archive('professionals'):
    case is_post_type_archive('capability'):
        $class = 'header transparent';
        break;
    default:
        $class = 'header @@alter-class';
} ?>

<!--header-->
<header class="<?php echo $class; ?>">
    <div class="container">
        <div class="header-inner">
            <?php if (isset($header['logo']['sizes'])) : ?>
                <div class="logo">
                    <a href="<?php echo home_url('/'); ?>">
                        <img src="<?php echo $header['logo']['sizes']['medium']; ?>" alt="<?php echo $header['logo']['alt']; ?>">
                    </a>
                </div>
            <?php endif; ?>
            <a href="<?php echo site_url().'?s='; ?>" class="search">
                <?php get_template_part('template-parts/svg/search'); ?>
            </a>
            <button class="btn-menu"><?php echo __('open navigation', 'barley-theme'); ?><span></span></button>
            <nav class="menu">
                <div class="holder">
                    <?php wp_nav_menu(array( 'menu'=>'header-menu', 'menu_class'=>'main-menu', 'container'=>'', 'menu_id'=>'header-menu', 'theme_location'=>'primary-menu', 'fallback_cb'=>'__return_empty_string', 'walker'=> new CustomMenuWalker()) ); ?>
                    <!--main-menu-->
                    <?php echo html_link_by_ACF_Link($header['button'], 'button'); ?>
                </div>
            </nav>
        </div>
    </div>
</header>
<!--header-->