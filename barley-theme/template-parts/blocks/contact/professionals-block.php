<?php
$field = get_field('professional_field');
if (!empty($field['our_professionals'])): ?>
    <div class="leadership">
        <?php if (isset($field['title']) && !empty($field['title'])) : ?>
            <h2><?php echo $field['title']; ?></h2>
        <?php endif; ?>
        <div class="team-list columns">
            <?php foreach ($field['our_professionals'] as $professional) :
                $show_popup = get_field('disclaimer_popup', $professional->ID);
                $info = get_field('prof_main_info', $professional->ID);
                $contact = get_field('contact_info', $professional->ID);
                $photo = get_featured_img_info('medium', $professional->ID); ?>
                <div class="item">
                    <?php if (!empty($photo['src'])) : ?>
                        <div class="photo-holder">
                            <div class="photo" style="background-image: url('<?php echo $photo['src']; ?>')">
                                <a href="<?php echo get_the_permalink($professional->ID); ?>"></a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="person-contacts">
                        <h4><a href="<?php echo get_the_permalink($professional->ID); ?>"><?php echo get_the_title($professional->ID); ?></a></h4>
                        <?php if (isset($info['position']) && !empty($info['position'])) : ?>
                            <div class="person-post"><?php echo $info['position']; ?></div>
                        <?php endif; ?>
                        <?php if (isset($info['description']) && !empty($info['description'])) : ?>
                            <p><?php echo $info['description']; ?></p>
                        <?php endif; ?>
                        <ul>
                            <?php if (isset($contact['phone']) && !empty($contact['phone'])) : ?>
                                <li><a href="<?php echo phone_url($contact['phone']); ?>"><?php echo $contact['phone']; ?></a></li>
                            <?php endif; ?>
                            <?php if (isset($contact['email']) && !empty($contact['email'])) :
                                if ($show_popup == true) : ?>
                                    <li><a href="#bio-popup" class="popup-opener"><?php echo $contact['email']; ?></a></li>
                                <?php else: ?>
                                    <li><a href="mailto:<?php echo $contact['email']; ?>"><?php echo $contact['email']; ?></a></li>
                                <?php endif;
                            endif; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!--leadership-->
<?php endif;