<?php
global $post;
$item_id = (!empty(get_query_var('post_id'))) ? get_query_var('post_id') : '';
$postid  = (!empty($item_id)) ? $item_id : $post->ID;
$field   = get_field('event_main_info', $postid);

if (is_front_page()) :
    $date  = get_event_date($field['date_begin'], $field['date_end'], $field['time_end'], $field['time_end'], 'home');
    $photo = get_featured_img_info('medium', $postid);
    $topics = get_topics_list($postid); ?>
    <div class="item">
        <?php if (!empty($photo['src'])) : ?>
            <div class="photo-holder">
                <div class="photo" style="background-image: url('<?php echo $photo['src']; ?>')">
                    <a href="<?php echo get_the_permalink($postid); ?>"></a>
                </div>
                <div class="label"><?php echo __('EVENTS', 'barley-theme'); ?></div>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="date"><?php echo $date['date']; ?></div>
            <?php if (!empty($topics)) : ?>
                <div class="categories">
                    <?php echo $topics; ?>
                </div>
            <?php endif; ?>
        </div>
        <h3 class="h5">
            <a href="<?php echo get_the_permalink($postid); ?>"><?php echo get_the_title($postid); ?></a>
        </h3>
    </div>
<?php else :
    $date = get_event_date($field['date_begin'], $field['date_end'], $field['time_begin'], $field['time_end'],'listing');?>
    <div class="item">
        <div class="dates-wrap">
            <?php if (!empty($date['date'])) : ?>
                <div class="dates">
                    <?php echo $date['date']; ?>
                </div>
            <?php endif; ?>
            <div class="avatars">
                <?php get_speakers_events($postid); ?>
            </div>
        </div>
        <div class="info">
            <div class="holder">
                <a href="<?php echo get_post_type_archive_link('events'); ?>"><?php echo __('event', 'barley-theme'); ?></a>
                <?php if (isset($field['location_text']) && !empty($field['location_text'])) : ?>
                    <div class="location"><?php echo $field['location_text']; ?></div>
                <?php endif; ?>
            </div>
            <h3 class="h5"><?php echo get_the_title($postid); ?></h3>
            <a href="<?php echo get_the_permalink($postid); ?>" class="learn-more">
                <span><?php echo __('Learn More', 'barley-theme'); ?></span>
                <?php set_query_var('color', 'black');
                get_template_part('template-parts/svg/arrow-right-2'); ?>
            </a>
        </div>
    </div>
<?php endif; ?>