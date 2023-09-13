<?php
global $post;
$item_id  = (!empty(get_query_var('post_id'))) ? get_query_var('post_id') : '';
$postid   = (!empty($item_id)) ? $item_id : $post->ID;
$category = get_categories_list($postid, 'label');
$image    = get_featured_img_info('medium_large', $postid);
$class   = (isset($args['class']) && $args['class'] == 'hide') ? 'item hide' : 'item';?>
<div class="<?php echo $class; ?>">
    <div class="photo-holder">
        <?php if (!empty($image['src'])) : ?>
            <div class="photo" style="background-image: url('<?php echo $image['src']; ?>')">
                <a href="<?php echo get_the_permalink($postid); ?>"></a>
            </div>
        <?php endif; ?>
        <?php if (!empty($category)) : ?>
            <div class="label"><?php echo $category; ?></div>
        <?php endif; ?>
    </div>
    <div class="date"><?php echo get_the_date('F j, Y', $postid); ?></div>
    <h3 class="h5"><?php echo get_the_title($postid); ?></h3>
    <?php echo (get_the_excerpt($postid)) ? '<p>'.get_the_excerpt($postid).'</p>' : ''; ?>
    <a href="<?php echo get_the_permalink($postid); ?>" class="learn-more">
        <span><?php echo __('Learn More', 'barley-theme'); ?></span>
        <?php set_query_var('color', '#7A7A7A');
        get_template_part('template-parts/svg/arrow-right-2'); ?>
    </a>
</div>