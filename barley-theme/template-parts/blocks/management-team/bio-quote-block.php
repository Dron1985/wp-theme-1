<?php
$field = get_field('bio_quote_field');
if (!empty($field)) : ?>
    <div class="bio-quote">
        <div class="container">
            <?php if (isset($field['title']) && !empty($field['title'])) : ?>
                <h2><?php echo $field['title']; ?></h2>
            <?php endif; ?>
            <div class="quote-holder">
                <?php if (isset($field['top_professional']) && !empty($field['top_professional'])) :
                    $professional = $field['top_professional'];
                    $photo   = get_featured_img_info('medium_large', $professional->ID);
                    $main    = get_field('prof_main_info', $professional->ID);
                    $contact = get_field('contact_info', $professional->ID);
                    $show_popup = get_field('disclaimer_popup', $professional->ID);
                    if (!empty($photo['src'])) : ?>
                        <div class="photo" style="background-image: url('<?php echo $photo['src']; ?>')"></div>
                    <?php endif; ?>
                    <div class="info">
                        <div class="name">
                            <h4><?php echo get_the_title($professional->ID); ?></h4>
                            <?php echo (isset($main['position']) && !empty($main['position'])) ? '<p>'.$main['position'].'</p>' : ''; ?>
                        </div>
                        <?php if (isset($main['description']) && !empty($main['description'])) : ?>
                            <p><?php echo $main['description']; ?></p>
                        <?php endif; ?>

                        <?php if (isset($contact['phone']) && !empty($contact['phone'])) : ?>
                            <p><a href="<?php echo phone_url($contact['phone']); ?>"><?php echo $contact['phone']; ?></a></p>
                        <?php endif; ?>

                        <?php if (isset($contact['phone']) && !empty($contact['phone'])) :
                            if ($show_popup == true) : ?>
                                <p><a href="#bio-popup" class="popup-opener"><?php echo $contact['email']; ?></a></p>
                            <?php else: ?>
                                <p><a href="mailto:<?php echo $contact['email']; ?>"><?php echo $contact['email']; ?></a></p>
                            <?php endif;
                        endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($field['quote']) && !empty($field['quote'])) :
                    $quote = $field['quote']; ?>
                    <div class="quote">
                        <?php get_template_part('template-parts/svg/quote'); ?>
                        <?php if (isset($quote['author']) || isset($quote['position'])) : ?>
                            <div class="title">
                                <?php echo (isset($quote['author']) && !empty($quote['author'])) ? '<h4>'.$quote['author'].'</h4>' : ''; ?>
                                <?php echo (isset($quote['position']) && !empty($quote['position'])) ? '<p>'.$quote['position'].'</p>' : ''; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($quote['text']) && !empty($quote['text'])) : ?>
                            <blockquote>
                                <?php echo $quote['text']; ?>
                            </blockquote>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!--bio-quote-->
<?php endif; ?>