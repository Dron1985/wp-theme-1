<?php
$field = get_field('capability_field');
if (!empty($field['capabilities'])): ?>
    <div class="capabilities">
        <div class="container">
            <div class="heading">
                <?php if (isset($field['title']) && !empty($field['title'])) : ?>
                    <h2><?php echo $field['title']; ?></h2>
                <?php endif; ?>
                <?php echo $field['description']; ?>
            </div>
            <div class="tabs-holder">
                <ul class="tabs-nav">
                    <?php $i = 1;
                    foreach ($field['capabilities'] as $capability) :
                        $active = ($i == 1) ? 'class="active"' : ''; ?>
                        <li <?php echo $active; ?>><a href="#"><?php echo $capability->name; ?></a></li>
                    <?php $i++; endforeach; ?>
                </ul>
                <div class="tabs">
                    <?php $i = 1;
                    foreach ($field['capabilities'] as $capability) :
                        $items = get_capability_by_term($capability->slug);
                        $class = ($i == 1) ? 'tab active' : 'tab'; ?>
                        <div class="<?php echo $class; ?>">
                            <?php if (!empty($items)) : ?>
                                <ul class="capabilities-list">
                                    <?php foreach ($items as $item) :
                                        $logo = get_field('capability_logo', $item->ID)?>
                                        <li>
                                            <?php if (isset($logo['sizes'])) : ?>
                                                <div class="icon">
                                                    <a href="<?php echo get_the_permalink($item->ID); ?>">
                                                        <img src="<?php echo $logo['sizes']['medium']; ?>" alt="<?php echo $logo['alt']; ?>">
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            <h6><a href="<?php echo get_the_permalink($item->ID); ?>"><?php echo get_the_title($item->ID); ?></a></h6>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <div class="more">
                                <a href="<?php echo get_post_type_archive_link('capability'); ?>" class="button">
                                    <?php echo __('See Our Services', 'barley-theme'); ?>
                                    <?php get_template_part('template-parts/svg/arrow-right-2'); ?>
                                </a>
                            </div>
                        </div>
                    <?php $i++; endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!--capabilities-->
<?php endif;