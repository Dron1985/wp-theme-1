<?php $leadership = get_leadership_by_id(get_the_ID());
if (!empty($leadership)) :
    $total = count($leadership);
    $count = 0;
    $number = 12; ?>
    <div class="leadership">
        <h2><?php echo __('Professionals at this Office', 'barley-theme'); ?></h2>
        <div class="team-list">
            <?php foreach ($leadership as $item) :
                $field = get_field('prof_main_info', $item['id']);
                $photo = get_featured_img_info('medium_large', $item['id']);
                if ($count == $number) {
                    break;
                } ?>
                <div class="item">
                    <?php if (!empty($photo['src'])) : ?>
                        <div class="photo-holder">
                            <div class="photo" style="background-image: url('<?php echo $photo['src']; ?>')">
                                <a href="<?php echo get_the_permalink($item['id']); ?>"></a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <h5><a href="<?php echo get_the_permalink($item['id']); ?>"><?php echo get_the_title($item['id']); ?></a></h5>
                    <?php if (isset($field['position']) && !empty($field['position'])) : ?>
                        <div class="person-post"><?php echo $field['position']; ?></div>
                    <?php endif; ?>
                </div>
            <?php $count++;
            endforeach; ?>
        </div>
        <?php if ($total > 12) : ?>
            <div class="more">
                <a href="javascript:void(0)" class="button" data-number="<?php echo $number; ?>" data-post-id="<?php echo get_the_ID(); ?>">
                    <?php echo __('Load More', 'barley-theme'); ?>
                    <?php get_template_part('template-parts/svg/arrow-right'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
    <!--leadership-->
<?php endif; ?>