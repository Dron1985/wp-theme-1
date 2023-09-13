<?php
switch (true) {
    case is_page_template('templates/practice-excellence.php'):
    case is_page_template('templates/your-life.php'):
    case is_page_template('templates/about-us.php'):
    case is_page_template('templates/careers.php'):
        $wrap_begin = '<div class="container">';
        $wrap_end = '</div>';
        break;
    default:
        $wrap_begin = '';
        $wrap_end = '';
}

$invert = get_field('invert_block');
$info = get_field('info_field');
if (!empty($info)):
    $class = ($invert == true) ? 'cascade-blocks invert' : 'cascade-blocks'; ?>
    <div class="<?php echo $class; ?>">
        <?php
        echo $wrap_begin;
        foreach ($info as $item) : ?>
            <div class="block">
                <?php if (isset($item['image']['sizes'])) : ?>
                    <div class="image" style="background-image: url('<?php echo $item['image']['sizes']['medium_large']; ?>')"></div>
                <?php endif; ?>
                <div class="info">
                    <?php if (isset($item['title']) && !empty($item['title'])) : ?>
                        <h2><?php echo $item['title']; ?></h2>
                    <?php endif; ?>
                    <?php echo $item['description']; ?>

                    <?php if (isset($item['button']['url']) && isset($item['button']['title']) && !empty($item['button']['title'])) :
                        $target = (isset($item['button']['target']) && !empty($item['button']['target'])) ? 'target="'. $item['button']['target'] .'"' : ''; ?>
                        <a href="<?php echo $item['button']['url']; ?>" class="button" <?php echo $target; ?>>
                            <?php echo $item['button']['title']; ?>
                            <?php get_template_part('template-parts/svg/arrow-right'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach;
        echo $wrap_end; ?>
    </div>
    <!--cascade-blocks-->
<?php endif;