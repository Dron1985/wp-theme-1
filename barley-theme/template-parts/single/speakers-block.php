<?php $field = get_field('speakers_field');
$speakers = ($field['type'] == 'list') ? $field['professionals'] : $field['speakers'];
if (!empty($speakers)) : ?>
    <div class="speakers">
        <?php if (isset($field['title']) && !empty($field['title'])) : ?>
            <h4><?php echo $field['title']; ?></h4>
        <?php endif; ?>
        <div class="team-list columns">
            <?php foreach ($speakers as $speaker) :
                if ($field['type'] == 'list') {
                    $show_popup = get_field('disclaimer_popup', $speaker->ID);
                    $info     = get_field('contact_info', $speaker->ID);
                    $name     = (isset($speaker->post_title)) ? $speaker->post_title : '';
                    $phone    = (isset($info['phone']) && !empty($info['phone'])) ? $info['phone'] : '';
                    $email    = (isset($info['email']) && !empty($info['email'])) ? $info['email'] : '';
                    $photo    = get_featured_img_info('thumbnail', $speaker->ID)['src'];
                    $link     = get_the_permalink($speaker->ID);
                    $linkedin = (isset($info['connect_field']['link_linkedin']) && !empty($info['connect_field']['link_linkedin'])) ? $info['connect_field']['link_linkedin'] : '';
                } else {
                    $show_popup = false;
                    $name     = (isset($speaker['full_name']) && !empty($speaker['full_name'])) ? $speaker['full_name'] : '';
                    $phone    = (isset($speaker['phone']) && !empty($speaker['phone'])) ? $speaker['phone'] : '';
                    $email    = (isset($speaker['email']) && !empty($speaker['email'])) ? $speaker['email'] : '';
                    $photo    = (isset($speaker['photo']['sizes'])) ? $speaker['photo']['sizes']['thumbnail'] : '';
                    $linkedin = (isset($speaker['linkedin']) && !empty($speaker['linkedin'])) ? $speaker['linkedin'] : '';
                } ?>
                <div class="item">
                    <?php if (!empty($photo)) : ?>
                        <div class="photo-holder">
                            <div class="photo" style="background-image: url('<?php echo $photo; ?>')">
                                <?php echo (isset($link)) ? '<a href="'.$link.'"></a>' : ''; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="person-contacts">
                        <?php if ($field['type'] == 'list') : ?>
                            <h6><a href="<?php echo $link; ?>"><?php echo $name; ?></a></h6>
                        <?php else : ?>
                            <h6><?php echo $name; ?></h6>
                        <?php endif; ?>

                        <?php if (!empty($phone) || !empty($email)) : ?>
                            <ul>
                                <li><a href="<?php echo phone_url($phone); ?>"><?php echo $phone; ?></a></li>
                                <?php if ($show_popup == true && !empty($email)) : ?>
                                    <li><a href="#bio-popup" class="popup-opener"><?php echo $email; ?></a></li>
                                <?php elseif ($show_popup == false && !empty($email)): ?>
                                    <li><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if (!empty($linkedin)) : ?>
                            <ul class="social-list">
                                <li>
                                    <a href="<?php echo $linkedin; ?>" target="_blank" rel="nofollow">
                                        <?php get_template_part('template-parts/svg/linkedin'); ?>
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>