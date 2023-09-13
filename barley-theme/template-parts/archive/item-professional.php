<?php
global $post;
$item_id = (!empty(get_query_var('post_id'))) ? get_query_var('post_id') : '';
$postid  = (!empty($item_id)) ? $item_id : $post->ID;
$photo   = get_featured_img_info('medium_large', $postid);
$info    = get_field('prof_main_info', $postid); ?>

<div class="item">
    <?php if (!empty($photo['src'])) : ?>
        <div class="photo-holder">
            <div class="photo" style="background-image: url('<?php echo $photo['src']; ?>')">
                <a href="<?php echo get_the_permalink($postid); ?>"></a>
            </div>
        </div>
    <?php endif; ?>
    <h5><a href="<?php echo get_the_permalink($postid); ?>"><?php echo get_the_title($postid); ?></a></h5>
    <?php if (isset($info['position']) && !empty($info['position'])) : ?>
        <div class="person-post"><?php echo $info['position']; ?></div>
    <?php endif; ?>
</div>