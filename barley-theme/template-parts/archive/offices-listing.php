<?php
$fields = get_field('fields_locations', 'option');
if (!empty($fields['offices_listing'])) : ?>
    <div class="locations-info">
        <div class="container">
            <?php foreach ($fields['offices_listing'] as $listing) :
                $class = (isset($listing['type_grid']) && $listing['type_grid'] == 'type1') ? 'main-offices' : 'community-offices';
                if (isset($listing['title']) && !empty($listing['title'])) : ?>
                    <h2><?php echo $listing['title']; ?></h2>
                <?php endif; ?>

                <div class="<?php echo $class; ?>">
                    <?php foreach ($listing['offices'] as $office) :
                        $f_img   = get_featured_img_info('medium_large', $office->ID);
                        $info    = get_field('location_main', $office->ID);
                        $address = (isset($info['contact_info']['address']) && !empty($info['contact_info']['address'])) ? $info['contact_info']['address'] : '';
                        $image   = (isset($info['listing_img']['sizes'])) ? $info['listing_img']['sizes']['medium_large'] : $f_img['src'];
                        $phone   = (isset($info['contact_info']['phone']) && !empty($info['contact_info']['phone'])) ? $info['contact_info']['phone'] : '';
                        $direction = (isset($info['contact_info']['direction_link']) && !empty($info['contact_info']['direction_link'])) ? $info['contact_info']['direction_link'] : ''; ?>
                        <div class="office">
                            <?php if ($listing['type_grid'] == 'type1' && !empty($image)) : ?>
                                <div class="image" style="background-image: url('<?php echo $image; ?>')">
                                    <a href="<?php echo get_the_permalink($office->ID); ?>"></a>
                                </div>
                            <?php endif; ?>
                            <div class="info">
                                <h4><a href="<?php echo get_the_permalink($office->ID); ?>"><?php echo get_the_title($office->ID); ?></a></h4>
                                <?php if (!empty($address)) : ?>
                                    <h6><?php echo __('Address', 'barley-theme'); ?></h6>
                                    <address><?php echo $address; ?></address>
                                <?php endif; ?>

                                <?php if ($listing['type_grid'] == 'type1' && !empty($phone)) : ?>
                                    <h6><?php echo __('Phone', 'barley-theme'); ?></h6>
                                    <p><a href="<?php echo phone_url($phone); ?>"><?php echo $phone; ?></a></p>
                                <?php endif; ?>

                                <?php if ($listing['type_grid'] == 'type1') : ?>
                                    <a href="<?php echo get_the_permalink($office->ID); ?>" class="button">
                                        <?php echo __('Learn More', 'barley-theme'); ?>
                                        <?php get_template_part('template-parts/svg/arrow-right-2'); ?>
                                    </a>
                                <?php elseif ($listing['type_grid'] == 'type2' && !empty($direction)) : ?>
                                    <a href="<?php echo $direction; ?>" class="directions-link" target="_blank">
                                        <span><?php echo __('Get directions', 'barley-theme'); ?></span>
                                        <?php set_query_var('color', '#7a7a7a');
                                        get_template_part('template-parts/svg/arrow-right-2'); ?>
                                    </a>
                                <?php endif; ?>

                                <?php if ($listing['type_grid'] == 'type2' && !empty($phone)) : ?>
                                    <h6><?php echo __('Phone', 'barley-theme'); ?></h6>
                                    <p><a href="<?php echo phone_url($phone); ?>"><?php echo $phone; ?></a></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>