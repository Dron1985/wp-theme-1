<?php
global $post;
$url = add_query_arg( array(
            'download_pdf' => $post->post_name,
            'type' => $post->post_type,
            'printformat' => 'PrintPDF'
        ), home_url('download-brochure/') );

$show_popup = get_field('disclaimer_popup');
$field = get_field('contact_info');
if (!empty($field['phone']) || !empty($field['email']) || !empty(array_filter($field['connect_field'])) || !empty($field['office'])) : ?>
    <div class="bio-contact-box">
        <div class="title"><?php echo __('Contact', 'barley-theme'); ?></div>
        <div class="wrap">
            <?php if (isset($field['phone']) && !empty($field['phone'])) : ?>
                <div class="h6"><?php echo __('Phone', 'barley-theme'); ?></div>
                <p><a href="<?php echo phone_url($field['phone']); ?>"><?php echo $field['phone']; ?></a></p>
            <?php endif; ?>

            <?php if (isset($field['email']) && !empty($field['email'])) : ?>
                <div class="h6"><?php echo __('Email', 'barley-theme'); ?></div>
                <?php if ($show_popup == true) : ?>
                    <p><a href="#bio-popup" class="popup-opener"><?php echo $field['email']; ?></a></p>
                <?php else: ?>
                    <p><a href="mailto:<?php echo $field['email']; ?>"><?php echo $field['email']; ?></a></p>
                <?php endif;
            endif; ?>

            <?php if (isset($field['connect_field']) && !empty(array_filter($field['connect_field']))) :
                $connect = $field['connect_field']; ?>
                <div class="h6"><?php echo __('Connect', 'barley-theme'); ?></div>
                <ul class="connect-list">
                    <?php if (isset($connect['link_linkedin']) && !empty($connect['link_linkedin'])) : ?>
                        <li>
                            <a href="<?php echo $connect['link_linkedin']; ?>" target="_blank" rel="nofollow">
                                <?php get_template_part('template-parts/svg/linkedin'); ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="print-ico-pdf">
                        <a href="<?php echo $url; ?>" target="_blank" rel="nofollow">
                            <?php get_template_part('template-parts/svg/pdf'); ?>
                        </a>
                    </li>

                    <?php if (isset($connect['vcard']['url']) && !empty($connect['vcard']['url'])) : ?>
                        <li>
                            <a href="<?php echo $connect['vcard']['url']; ?>" target="_blank">
                                <?php get_template_part('template-parts/svg/vcard'); ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($connect['link_google_maps']) && !empty($connect['link_google_maps'])) : ?>
                        <li>
                            <a href="<?php echo $connect['link_google_maps']; ?>" target="_blank">
                                <?php get_template_part('template-parts/svg/location'); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>
        <?php if (isset($field['office']) && !empty($field['office'])) : ?>
            <div class="wrap">
                <div class="h6"><?php echo __('Office', 'barley-theme'); ?></div>
                <address>
                    <?php foreach ($field['office'] as $office) : ?>
                        <p><?php echo $office->post_title; ?></p>
                    <?php endforeach; ?>
                </address>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>