<?php
switch (true) {
    case is_post_type_archive('jobs'):
        $fields = get_field('fields_careers', 'option');
        $banner = $fields['banner_field'];
        break;
    default:
        $banner = get_field('banner_field');
}

$class = (is_page_template('templates/about-us.php')) ? 'visual content-bottom' : 'visual';

if (!empty(array_filter($banner))):
    $bg_img = (isset($banner['bg_img']['sizes'])) ? 'style="background-image: url('.$banner['bg_img']['sizes']['full-hd'].')"' : ''; ?>
    <div class="<?php echo $class; ?>" <?php echo $bg_img; ?>>
        <div class="container">
            <div class="holder">
                <?php if (isset($banner['title']) && !empty($banner['title'])) : ?>
                    <h2><?php echo $banner['title']; ?></h2>
                <?php endif; ?>
                <?php echo $banner['description']; ?>

                <?php if (isset($banner['button']['url']) && isset($banner['button']['title']) && !empty($banner['button']['title'])) :
                    $target = (isset($banner['button']['target']) && !empty($banner['button']['target'])) ? 'target="'. $banner['button']['target'] .'"' : ''; ?>
                    <a href="<?php echo $banner['button']['url']; ?>" class="button" <?php echo $target; ?>>
                        <?php echo $banner['button']['title']; ?>
                        <?php get_template_part('template-parts/svg/arrow-right'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!--visual-->
<?php endif;