<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package barley-theme
 */

get_header();
    $page_contact = get_page_ID_by_page_template('templates/contact-us');
    $field = get_field('location_main');
    $image = get_featured_img_info('medium_large', get_the_ID()); ?>
    <main class="main">
        <div class="container">
            <div class="info-details">
                <div class="description">
                    <?php if (!empty($page_contact)) : ?>
                        <p>
                            <a href="<?php echo get_the_permalink($page_contact); ?>" class="back-link">
                                <?php get_template_part('template-parts/svg/back-to'); ?>
                                <span><?php echo __('Back to Contact Us', 'barley-theme'); ?></span>
                            </a>
                        </p>
                    <?php endif; ?>
                    <div class="sub-title"><?php echo __('Office',  'barley-theme'); ?></div>
                    <h2><?php the_title(); ?></h2>
                    <div class="info-table">
                        <?php if (isset($field['contact_info']) && !empty(array_filter($field['contact_info']))) :
                            $contact_info = $field['contact_info']; ?>
                            <div class="row">
                                <div class="cell">
                                    <h5><?php echo __('Contact', 'barley-theme'); ?></h5>
                                </div>
                                <div class="cell">
                                    <?php if (isset($contact_info['address']) && !empty($contact_info['address'])) : ?>
                                        <h6><?php echo __('Address', 'barley-theme'); ?></h6>
                                        <address><?php echo $contact_info['address']; ?></address>
                                    <?php endif; ?>

                                    <?php if (isset($contact_info['direction_link']) && !empty($contact_info['direction_link'])) : ?>
                                        <a href="<?php echo $contact_info['direction_link']; ?>" class="directions-link" target="_blank">
                                            <span><?php echo __('Get directions', 'barley-theme'); ?></span>
                                            <?php get_template_part('template-parts/svg/get-direction'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="cell">
                                    <?php if (isset($contact_info['phone']) && !empty($contact_info['phone'])) : ?>
                                        <h6><?php echo __('Phone', 'barley-theme'); ?></h6>
                                        <p><a href="<?php echo phone_url($contact_info['phone']); ?>"><?php echo $contact_info['phone']; ?></a></p>
                                    <?php endif; ?>

                                    <?php if (isset($contact_info['fax']) && !empty($contact_info['fax'])) : ?>
                                        <h6><?php echo __('Fax', 'barley-theme'); ?></h6>
                                        <p><a href="<?php echo phone_url($contact_info['fax']); ?>"><?php echo $contact_info['fax']; ?></a></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($field['access_information']) && !empty(array_filter($field['access_information']))) :
                            $access_info = $field['access_information']; ?>
                            <div class="row">
                                <div class="cell">
                                    <h5><?php echo __('Access Information', 'barley-theme'); ?></h5>
                                </div>
                                <div class="cell">
                                    <?php if (isset($access_info['office_hours']) && !empty($access_info['office_hours'])) : ?>
                                        <h6><?php echo __('Office Hours', 'barley-theme'); ?></h6>
                                        <p><?php echo $access_info['office_hours']; ?></p>
                                    <?php endif; ?>

                                    <?php if (isset($access_info['office_reception']) && !empty($access_info['office_reception'])) : ?>
                                        <h6><?php echo __('Office Reception', 'barley-theme'); ?></h6>
                                        <ul>
                                            <?php foreach ($access_info['office_reception'] as $item) : ?>
                                                <li><?php echo $item['text']; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                                <?php if (isset($access_info['parking_details']) && !empty($access_info['parking_details'])) : ?>
                                    <div class="cell">
                                        <h6><?php echo __('Parking Details', 'barley-theme'); ?></h6>
                                        <?php echo $access_info['parking_details']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (!empty($image['src'])) : ?>
                    <div class="image">
                        <img src="<?php echo $image['src']; ?>" alt="<?php echo $image['alt']; ?>">
                    </div>
                <?php endif; ?>
            </div>
            <!--info-details-->
            <?php get_template_part('template-parts/single/leaderships'); ?>
        </div>
    </main>
<?php get_footer();