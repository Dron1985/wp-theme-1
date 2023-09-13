<?php
global $post;
$item_id = (!empty(get_query_var('post_id'))) ? get_query_var('post_id') : '';
$postid  = (!empty($item_id)) ? $item_id : $post->ID;
$category = get_categories_list($postid, 'label');
$class   = (isset($args['class']) && $args['class'] == 'hide') ? 'item hide' : 'item'; ?>
<div class="<?php echo $class; ?>">
    <?php if (is_front_page()) : ?>
        <div class="box">
            <span class="date"><?php echo get_the_date('F j, Y', $postid); ?></span>
        </div>
    <?php else: ?>
        <?php if (!empty($category)) : ?>
            <div class="label"><?php echo $category; ?></div>
        <?php endif; ?>
        <div class="date"><?php echo get_the_date('F j, Y', $postid); ?></div>
    <?php endif; ?>

    <h3 class="h5"><?php echo get_the_title($postid); ?></h3>
    <?php if (get_the_excerpt($postid)) : ?>
        <p><?php do_excerpt(get_the_excerpt($postid), 75); ?></p>
    <?php endif; ?>
    <a href="<?php echo get_the_permalink($postid); ?>" class="learn-more">
        <span><?php echo __('Learn More', 'barley-theme'); ?></span>
        <?php set_query_var('color', '#FFFFFF');
        get_template_part('template-parts/svg/arrow-right-2'); ?>
    </a>
</div>