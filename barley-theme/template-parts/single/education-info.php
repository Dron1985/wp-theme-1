<?php $field = get_field('general_info');
if (!empty(array_filter($field))) : ?>
    <div class="bio-info content">
        <?php if (isset($field['education']) && !empty($field['education'])) : ?>
            <div class="h5"><?php echo __('Education', 'barley-theme'); ?></div>
            <ul>
                <?php foreach ($field['education'] as $education) : ?>
                    <li><?php echo $education['text']; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (isset($field['admissions']) && !empty($field['admissions'])) : ?>
            <div class="h5"><?php echo __('Admissions', 'barley-theme'); ?></div>
            <ul>
                <?php foreach ($field['admissions'] as $admission) : ?>
                    <li><?php echo $admission['admission']; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (isset($field['capabilities']) || isset($field['industries'])) : ?>
            <div class="bio-info-column">
                <?php if (isset($field['capabilities']) && !empty($field['capabilities'])) : ?>
                    <div class="wrap">
                        <div class="h5"><?php echo __('Capabilities', 'barley-theme'); ?></div>
                        <ul>
                            <?php foreach ($field['capabilities'] as $capability) : ?>
                                <li><a href="<?php echo get_the_permalink($capability->ID); ?>"><?php echo $capability->post_title; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (isset($field['industries']) && !empty($field['industries'])) : ?>
                    <div class="wrap">
                        <div class="h5"><?php echo __('Industries', 'barley-theme'); ?></div>
                        <ul>
                            <?php foreach ($field['industries'] as $industry) : ?>
                                <li><a href="<?php echo get_the_permalink($industry->ID); ?>"><?php echo $industry->post_title; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($field['communities']) && !empty($field['communities'])) : ?>
            <h5><?php echo __('Community Involvement', 'barley-theme'); ?></h5>
            <div class="limited-information">
                <?php $i = 1;
                foreach ($field['communities'] as $community) :
                    $class = ($i <= 3) ? 'item' : 'item hide'; ?>
                    <div class="<?php echo $class; ?>">
                        <h6><?php echo $community['title']; ?></h6>
                        <p><?php echo $community['position']; ?></p>
                    </div>
                <?php $i++; endforeach;
                if (count($field['communities']) > 3) : ?>
                    <button class="add-more"><span><?php echo __('Show More', 'barley-theme'); ?></span></button>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>