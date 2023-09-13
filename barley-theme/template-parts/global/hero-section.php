<?php
$back_link = '';
$link_title = '';
$bg_img = '';
switch (true) {
    case is_page_template('templates/contact-us.php'):
    case is_page_template('templates/careers.php'):
        $field = get_field('hero_field');
        break;
    case is_page_template('templates/management-team.php'):
        $field = get_field('hero_field');
        if (get_page_ID_by_page_template('templates/about-us.php')) {
            $page_id = get_page_ID_by_page_template('templates/about-us.php');
            $back_link = get_the_permalink($page_id);
            $link_title = 'Back to About Us';
        }
        break;
    case is_page_template('templates/practice-excellence.php'):
        $field = get_field('hero_field');
        if (get_page_ID_by_page_template('templates/about-us.php')) {
            $page_id = get_page_ID_by_page_template('templates/about-us.php');
            $back_link = get_the_permalink($page_id);
            $link_title = 'Back to About Us';
        }
        break;
    case is_page_template('templates/your-life.php'):
    case is_post_type_archive('jobs'):
        if (is_post_type_archive('jobs')) {
            $fields = get_field('fields_careers', 'option');
            $field  = $fields['hero_field'];
        } else {
            $field = get_field('hero_field');
        }
        if (get_page_ID_by_page_template('templates/careers.php')) {
            $page_id = get_page_ID_by_page_template('templates/careers.php');
            $back_link = get_the_permalink($page_id);
            $link_title = 'Back to Careers';
        }
        break;
    case is_post_type_archive('locations'):
        $fields = get_field('fields_locations', 'option');
        $field  = $fields['hero_field'];
        if (get_page_ID_by_page_template('templates/about-us.php')) {
            $page_id = get_page_ID_by_page_template('templates/about-us.php');
            $back_link = get_the_permalink($page_id);
            $link_title = 'Back to About Us';
        }
        break;
    case is_post_type_archive('resources'):
        $fields = get_field('fields_resources', 'option');
        $field  = $fields['hero_field'];
        break;
    case is_post_type_archive('events'):
        $fields = get_field('fields_events', 'option');
        $field  = $fields['hero_field'];
        break;
    case is_post_type_archive('professionals'):
        $fields = get_field('fields_professionals', 'option');
        $field  = $fields['hero_field'];
        break;
    case is_post_type_archive('capability'):
        $fields = get_field('fields_capabilities', 'option');
        $field  = $fields['hero_field'];
        break;
    case is_home():
        $page_news = get_option('page_for_posts');
        $field     = get_field('news_hero_field', $page_news);
        break;
    default:
        $field = get_field('hero_field');
}

if (isset($field['bg_img']['sizes'])) {
    $bg_img = (isset($field['bg_img']['sizes'])) ? 'style="background-image: url('.$field['bg_img']['sizes']['full-hd'].')"' : '';
} else {
    $image  = get_featured_img_info('full-hd', get_the_ID());
    $bg_img = (!empty($image['src'])) ? 'style="background-image: url('.$image['src'].')"' : '';
} ?>

<div class="page-title" <?php echo $bg_img; ?>>
    <div class="container">
        <div class="info">
            <?php if (isset($back_link) && !empty($back_link)) : ?>
                <a href="<?php echo $back_link; ?>" class="back-link">
                    <?php get_template_part('template-parts/svg/back-to'); ?>
                    <span><?php echo $link_title; ?></span>
                </a>
            <?php endif; ?>

            <?php if (!empty($field['title'])) : ?>
                <h1><?php echo $field['title']; ?></h1>
            <?php endif; ?>
            <?php echo $field['description']; ?>

            <?php if (isset($field['button']['url']) && isset($field['button']['title']) && !empty($field['button']['title'])) :
                $target = (isset($field['button']['target']) && !empty($field['button']['target'])) ? 'target="'. $field['button']['target'] .'"' : ''; ?>
                <a href="<?php echo $field['button']['url']; ?>" class="button white" <?php echo $target; ?>>
                    <?php echo $field['button']['title']; ?>
                    <?php set_query_var('color', 'black');
                    get_template_part('template-parts/svg/arrow-right-2'); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<!--page-title-->