<?php
global $post;
$item_id = (!empty(get_query_var('post_id'))) ? get_query_var('post_id') : '';
$postid  = (!empty($item_id)) ? $item_id : $post->ID;
$field   = get_field('job_main_info', $postid); ?>
<div class="item">
    <div class="position-description">
        <h4><a href="<?php echo get_the_permalink($postid); ?>"><?php echo get_the_title($postid); ?></a></h4>
        <?php if (isset($field['location']) && !empty($field['location'])) : ?>
            <div class="location">
                <div class="ico"><img src="<?php echo get_template_directory_uri(); ?>/dist/images/ico-locations.svg" alt="ico"></div>
                <strong class="city"><?php echo $field['location']->post_title; ?></strong>
            </div>
        <?php endif; ?>
        <div class="position-description">
            <?php echo (get_the_excerpt($postid)) ? '<p>'.get_the_excerpt($postid).'</p>' : ''; ?>
        </div>
    </div>
    <a href="<?php echo get_the_permalink($postid); ?>" class="button">
        <?php echo __('Learn More', 'barley-theme'); ?>
        <?php get_template_part('template-parts/svg/arrow-right-2'); ?>
    </a>
</div>