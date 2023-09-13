<?php
$leaderships = get_field('leadership_field');

if (!empty($leaderships)) : ?>
    <div class="leadership">
        <div class="container">
            <?php foreach ($leaderships as $leadership) :
                $class = (isset($leadership['type_grid']) && $leadership['type_grid'] == 'two-in-row') ? 'team-list two-in-row' : 'team-list three-in-row';
                if (isset($leadership['title']) && !empty($leadership['title'])) : ?>
                    <h2><?php echo $leadership['title']; ?></h2>
                <?php endif; ?>
                <div class="<?php echo $class; ?>">
                    <?php foreach ($leadership['team'] as $employee) :
                        $show_popup = get_field('disclaimer_popup', $employee->ID);
                        $info = get_field('prof_main_info', $employee->ID);
                        $contact = get_field('contact_info', $employee->ID);
                        $photo = get_featured_img_info('medium_large', $employee->ID);?>
                        <div class="item">
                            <?php if (!empty($photo['src'])) : ?>
                                <div class="photo-holder">
                                    <div class="photo" style="background-image: url('<?php echo $photo['src']; ?>')">
                                        <a href="<?php echo get_the_permalink($employee->ID); ?>"></a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <h4><a href="<?php echo get_the_permalink($employee->ID); ?>"><?php echo get_the_title($employee->ID); ?></a></h4>

                            <?php if (isset($leadership['type_grid']) && $leadership['type_grid'] == 'three-in-row') :
                                echo (isset($info['description']) && !empty($info['description'])) ? $info['description'] : '';
                                if (isset($info['position']) && !empty($info['position'])) : ?>
                                    <div class="person-post"><?php echo $info['position']; ?></div>
                                <?php endif;
                            else:
                                if (isset($info['position']) && !empty($info['position'])) : ?>
                                    <div class="person-post"><?php echo $info['position']; ?></div>
                                <?php endif;
                                echo (isset($info['description']) && !empty($info['description'])) ? $info['description'] : '';
                            endif; ?>

                            <?php if (isset($contact['phone']) && !empty($contact['phone'])) : ?>
                                <p><a href="<?php echo phone_url($contact['phone']); ?>"><?php echo $contact['phone']; ?></a></p>
                            <?php endif; ?>

                            <?php if (isset($contact['email']) && !empty($contact['email'])) :
                                if ($show_popup == true) : ?>
                                    <p><a href="#bio-popup" class="popup-opener"><?php echo $contact['email']; ?></a></p>
                                <?php else: ?>
                                    <p><a href="mailto:<?php echo $contact['email']; ?>"><?php echo $contact['email']; ?></a></p>
                                <?php endif;
                            endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!--leadership-->
<?php endif; ?>