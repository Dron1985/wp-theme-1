<?php
$field = get_field('fields_locations', 'option');
if (!empty($field['firm_updates_field'])) :
    $subscribe = $field['firm_updates_field'];
    if (is_singular('resources') || is_singular('post')) : ?>
        <div class="aside-info-wrap">
            <?php if (isset($subscribe['title']) && !empty($subscribe['title'])) : ?>
                <h4><?php echo $subscribe['title']; ?></h4>
            <?php endif; ?>
            <?php echo $subscribe['description']; ?>

            <?php if (isset($subscribe['subscribe_form']) && !empty($subscribe['subscribe_form'])) :?>
                <a href="#subscribe-popup" class="button popup-opener">
                    <?php echo __('Subscribe for Updates', 'barley-theme'); ?>
                    <?php get_template_part('template-parts/svg/arrow-right-2'); ?>
                </a>
            <?php endif; ?>
        </div>
    <?php elseif (is_home() || (isset($args['type']) && $args['type'] == 'news')) : ?>
        <div class="subscribe">
            <div class="box">
                <?php if (isset($subscribe['title']) && !empty($subscribe['title'])) : ?>
                    <h3 class="h2"><?php echo $subscribe['title']; ?></h3>
                <?php endif; ?>
                <?php echo $subscribe['description']; ?>
                <?php if (isset($subscribe['subscribe_form']) && !empty($subscribe['subscribe_form'])) : ?>
                    <br/>
                    <a href="#subscribe-popup" class="button white popup-opener">
                        <?php echo __('Subscribe for Updates', 'barley-theme'); ?>
                        <?php get_template_part('template-parts/svg/arrow-right-2'); ?>
                    </a>
                <?php endif; ?>
                <?php //echo (isset($subscribe['subscribe_form']) && !empty($subscribe['subscribe_form'])) ? do_shortcode($subscribe['subscribe_form']) : ''; ?>
            </div>
        </div>
    <?php else : ?>
        <div class="contact-boxes with-form align-center">
            <div class="container">
                <div class="holder">
                    <div class="box subscribe-box">
                        <div class="wrap">
                            <?php if (isset($subscribe['title']) && !empty($subscribe['title'])) : ?>
                                <h2><?php echo $subscribe['title']; ?></h2>
                            <?php endif; ?>
                            <?php echo $subscribe['description']; ?>
                            <?php if (isset($subscribe['subscribe_form']) && !empty($subscribe['subscribe_form'])) : ?>
                                <a href="#subscribe-popup" class="button white popup-opener">
                                    <?php echo __('Subscribe for Updates', 'barley-theme'); ?>
                                    <?php get_template_part('template-parts/svg/arrow-right-2'); ?>
                                </a>
                            <?php endif; ?>

                            <?php // echo (isset($subscribe['subscribe_form']) && !empty($subscribe['subscribe_form'])) ? do_shortcode($subscribe['subscribe_form']) : ''; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--contact-boxes-->
    <?php endif;
endif; ?>